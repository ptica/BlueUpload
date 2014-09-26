# BlueUpload frontend for CakePHP

this composer package provides CakePHP intergration with blueimp's [JQuery-File-Upload](https://github.com/blueimp/jQuery-File-Upload).

```
  bower install blueimp-file-upload
  composer require ptica/BlueUpload:dev-master
```

the package comes with a routes.php file that
connects /upload/* to the plugin BlueUpload controller
that constructs the JQuery-File-Upload class and carries out the upload request

resulting file id is returned through ajax into host HTML form,
a precompiled image/file template is rendered using handlebars runtime and localization
(Gruntfile.js handles build process for these resources)


