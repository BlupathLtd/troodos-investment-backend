<?php

namespace BL\CategoriesTags\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBlInvestmentOpportunitiesAddCategoryId extends Migration
{
    public function up()
    {
        if (Schema::hasTable('bl_regionalinvestment_investment_opportunities') && !Schema::hasColumn('bl_regionalinvestment_investment_opportunities', 'category_id')) {
            Schema::table('bl_regionalinvestment_investment_opportunities', function ($table) {
                $table->bigInteger('category_id')->nullable()->unsigned();
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('bl_regionalinvestment_investment_opportunities') && Schema::hasColumn('bl_regionalinvestment_investment_opportunities', 'category_id')) {
            Schema::table('bl_regionalinvestment_investment_opportunities', function ($table) {
                $table->dropColumn('category_id');
            });
        }
    }
}