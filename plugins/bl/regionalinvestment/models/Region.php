<?php

namespace BL\RegionalInvestment\Models;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Model;
use October\Rain\Database\Traits\Sortable;

/**
 * Model
 */
class Region extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use Sortable;

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;
    protected $jsonable = ['sections', 'photos'];
    public $implement = [
        'RainLab.Translate.Behaviors.TranslatableModel',
        '@BL.CategoriesTags.Behaviors.HasTagsAndCategoriesModel',
        'Bl.Maps.Behaviors.PositionableOnMapModel'
        ];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'bl_regionalinvestment_regions';

    public $belongsToMany = [
        'investment_oppotunities' => [
            'BL\RegionalInvestment\Models\InvestmentOpportunity',
            'table'    => 'bl_regionalinvestment_i_o_region',
            'key'      => 'r_id',
            'otherKey' => 'i_o_id'
        ],
    ];

    public $hasMany = [
        'communities' => 'BL\RegionalInvestment\Models\Community',
        'points_of_interest' =>  'BL\RegionalInvestment\Models\PointOfInterest',
    ];

    public $translatable = ['name', 'description', 'sections'];
    public $fillable = ['primary'];

    /**
     * @var array Validation rules
     */
    public $rules = [
        'name' => 'required',
        'slug' => 'required|unique:bl_regionalinvestment_regions,slug',
        'description' => 'required',
        'website' => 'url'
    ];

    public $attachMany = [
        'gallery' => 'System\Models\File'
    ];

    public static function getLocalized()
    {
        $regions = Cache::rememberForever("all.Regions" . App::getLocale(), function () {
            return self::where('published', 1)->get()->toArray();
        });
        return collect($regions);
    }

    public function beforeSave()
    {
        //Ensure only 1 primary
        $regions = self::where('primary', 1)->get();
        if ($this->primary == 1) {
            if ($regions) {
                DB::table('bl_regionalinvestment_regions')->where('primary', 1)->update(['primary' => 0]);
            }
        }
        return $this;
    }

    public function afterSave()
    {
        //Ensure only 1 primary
        $regions = self::where('primary', 1)->get();
        if ($regions->count() == 0) {
            DB::table('bl_regionalinvestment_regions')->where('id', $this->id)->update(['primary' => 1]);
        }
        Cache::forget("all.Regionsen");
        Cache::forget("all.Regionsel");
    }
}
