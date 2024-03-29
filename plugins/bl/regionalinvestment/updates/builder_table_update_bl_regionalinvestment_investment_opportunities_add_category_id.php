<?php

namespace BL\RegionalInvestment\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBlRegionalinvestmentInvestmentOpportunitiesAddCategoryId extends Migration
{
    public function up()
    {
        if (Schema::hasTable('bl_regionalinvestment_investment_opportunities') && !Schema::hasColumn('bl_regionalinvestment_investment_opportunities', 'category_id')) {
            Schema::table('bl_regionalinvestment_investment_opportunities', function ($table) {
                $table->bigInteger('category_id')->nullable()->unsigned();
                $table->foreign('category_id', 'bl_reginv_opportunities_category_id_for
                  eign')->references('id')->on('bl_categoriestags_categories')->onDelete('set null')->onUpdate('cascade');
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
