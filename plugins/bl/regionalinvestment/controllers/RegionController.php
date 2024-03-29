<?php

namespace BL\RegionalInvestment\Controllers;

use Backend\Classes\Controller;
use BL\RegionalInvestment\Models\Region;
use BackendMenu;
use RainLab\Translate\Classes\Translator;

class RegionController extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController',
        'Backend\Behaviors\ReorderController',
        'Backend\Behaviors\RelationController'
    ];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';
    public $relationConfig = 'config_relation.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('BL.RegionalInvestment', 'regional-investment', 'regional-investment-regions');
    }

    public function api_get()
    {
        $translator = Translator::instance();
        $activeLocale = $translator->getLocale();
        return $activeLocale;
    }
}
