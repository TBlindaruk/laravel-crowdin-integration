<?php

namespace Maksi\LaravelCrowdinIntegration\Commands;

use ElKuKu\Crowdin\Crowdin;
use Exception;
use Illuminate\Support\Str;
use Maksi\LaravelCrowdinIntegration\BaseCommand;
use RuntimeException;
use ZanySoft\Zip\Zip;
use ZipArchive;

class DownloadAll extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crowdin:download';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download a zip file containing all language files from Crowdin';

    protected $crowdin;

    public function __construct()
    {
        parent::__construct();

        $this->crowdin = new Crowdin(config('crowdin.project_id'), config('crowdin.api_key'));
    }

    /**
     * Execute the console command.
     */
    public function handle(ZipArchive $archive): void
    {
        $mapping = config('crowdin.mapping', null);
        $thisLangDir = base_path('resources') . '/lang';
        $dirInCrowdinProject = config('crowdin.crowdin_dir', false);

        $destination = $thisLangDir . 'all.' . Str::random();

        $this->call('crowdin:build');

        $this->crowdin->translation->download('all.zip', $destination . '.zip');

        try {
            $archive->extractTo(base_path('resources') . '/lang');

        } catch (Exception $exception) {
            throw new RuntimeException($exception->getMessage());
        }

        unlink($destination . '.zip');
        $this->rrmdir($destination);
    }

    protected function rrmdir($dir): void
    {
        $objects = $this->getFilesNameFromDir($dir);

        foreach ($objects as $object) {
            if (is_dir($dir . DIRECTORY_SEPARATOR . $object)) {
                $this->rrmdir($dir . DIRECTORY_SEPARATOR . $object);
            } else {
                unlink($dir . DIRECTORY_SEPARATOR . $object);
            }
        }

        reset($objects);
        rmdir($dir);
    }
}
