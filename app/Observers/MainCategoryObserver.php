<?php

namespace App\Observers;

use App\model\MainCategory;

class MainCategoryObserver
{
    /**
     * Handle the model main category "created" event.
     *
     * @param MainCategory $MainCategory
     * @return void
     */
    public function created(MainCategory $MainCategory)
    {

    }

    /**
     * Handle the model main category "updated" event.
     *
     * @param MainCategory $MainCategory
     * @return void
     */
    public function updated(MainCategory $MainCategory)
    {
        return $MainCategory->vendor()->update(['active'=> $MainCategory->active ]);
    }

    /**
     * Handle the model main category "deleted" event.
     *
     * @param MainCategory $MainCategory
     * @return void
     */
    public function deleted(MainCategory $MainCategory)
    {
        //
    }

    /**
     * Handle the model main category "restored" event.
     *
     * @param MainCategory $MainCategory
     * @return void
     */
    public function restored(MainCategory $MainCategory)
    {
        //
    }

    /**
     * Handle the model main category "force deleted" event.
     *
     * @param MainCategory $MainCategory
     * @return void
     */
    public function forceDeleted(MainCategory $MainCategory)
    {
        //
    }
}
