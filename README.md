# Laravel-Crowdin Integration
Automate uploading/downloading translations 
## Installation

Install the package via composer:

```composer require maksi/laravel-crowdin-integration --dev```

By default, the package uses the following environment variables
```
CROWDIN_PROJECT_ID
CROWDIN_API_KEY
```


After that, `config/crowdin.php` will be created. Inside this file you will find all the fields that can be edited in this package.

## Usage

You can see all the commands in the list of command:
```
php artisan list
```
### Add File
Add a file from project to Crowdin repository:
```
php artisan crowdin:add {fileName.ext}
```
> It is work only for adding file, not for updating
### Update File
Update exist file from project to Crowdin repository
```
php artisan crowdin:update {fileName.ext}
```
> It is work only for updating file, not for adding
### Upload File
This is command add or update all origin files from a project in Crowdin repository:
```
php artisan crowdin:upload
```
> No matter file exists or not in Crowdin repository
### Build 
Build ZIP archive with the latest translations.
```
php artisan crowdin:build
```
### Download Files
Download translations files from Crowdin repository to your.
```
php artisan crowdin:download
```

### Thanks

Forked from the https://packagist.org/packages/macpaw/laravel-crowdin-integration