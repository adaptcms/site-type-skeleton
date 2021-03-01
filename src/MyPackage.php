<?php

namespace :uc:vendor\:uc:package;

use Adaptcms\SiteTypes\Models\SiteType;

class :uc:package
{
  /**
  * On Install
  *
  * @return void
  */
  public function onInstall()
  {
    SiteType::syncPackageFolder(get_class());
  }
}
