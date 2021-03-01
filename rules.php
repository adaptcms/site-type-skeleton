<?php

// Available placeholders: :uc:vendor, :uc:package, :lc:vendor, :lc:package
return [
  'src/MyPackage.php' => 'src/:uc:package.php',
  'config/mypackage.php' => 'config/:lc:package.php',
  'src/Facades/MyPackage.php' => 'src/Facades/:uc:package.php',
  'src/MyPackageServiceProvider.php' => 'src/:uc:packageServiceProvider.php',
  'src/SiteType/MyPackage.php' => 'src/SiteType/:uc:package.php',
  'package.json' => 'package.json'
];
