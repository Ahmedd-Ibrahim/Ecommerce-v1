<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategory as RequestSubCategory;
use App\model\MainCategory;
use App\model\SubCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class subCategoryController extends Controller
{
    public function index()
    {
        $sub_categories = SubCategory::default()->paginate(PAGINATION_COUNT);
        return view('back.subCategories.index', compact('sub_categories'));
    }

    public function create()
    {
        $default_lang = default_lang();
        $categories = MainCategory::where('translation_lang', $default_lang)->selection()->get();
        return view('back.subCategories.add', compact('categories'));
    }

    public function store(RequestSubCategory $request)
    {

        try {
            DB::beginTransaction();
            /* push the request to collect & get default category  */
            $cat = collect($request->category);
            $filter = $cat->filter(function ($val, $key) {
                return $val['abbr'] == default_lang();
            });
            /* check & upload category Image */
            $filePath = "";
            if ($request->has('photo')) {
                $filePath = uploadImage('subCategory', $request->photo);
            }
            /* get default category as 0 index */
            $default_category = array_values($filter->all())[0];
            /* insert default category & return ID */
            $defaultCatId = SubCategory::insertGetId([
                'translation_lang' => $default_category['abbr'],
                'translation_of' => 0,
                'name' => $default_category['name'],
                'slug' => $default_category['name'],
                'category_id' => $request->parent,
                'photo' => $filePath,
            ]);

            /* get this category with deffrent languages */
            $categoriesLang = $cat->filter(function ($val, $key) {
                return $val['abbr'] !== default_lang();
            });

            /* check category status & strore it in var */

            /* check inputs before saving to array */
            if (isset($categoriesLang) && $categoriesLang->count() > 0) {
                $categories_arr = [];
                foreach ($categoriesLang as $category) {
                    isset($category['active']) ? $active = 1 : $active = 0;
                    $categories_arr[] = [
                        'name' => $category['name'],
                        'translation_lang' => $category['abbr'],
                        'translation_of' => $defaultCatId,
                        'category_id' => $request->parent,
                        'slug' => $category['name'],
                        'active' => $active,
                        'photo' => $filePath,
                    ];

                }
                SubCategory::insert($categories_arr);
            }
            DB::commit();
            return redirect()->route('admin.subCategories')->with(['success' => 'تم أضافة القسم بنجاح']);
        } catch (\Exception $ex) {

            DB::rollback();
            redirect()->route('admin.subCategories')->with(['error' => 'هناك خطأ ما حاول مرة أخري']);
        }
    }
    public function edit($id)
    {
        $SubCategory = SubCategory::find($id);
        if (!$SubCategory) {
            return redirect()->route('admin.subCategories')->with(['error' => 'هذا القسم غير موجود']);
        }

        return view('back.subCategories.edit', compact('SubCategory'));

    }
    public function update($id, Request $request)
    {
        try {
            DB::beginTransaction();
            $category = SubCategory::find($id);
            if (!$category) {
                return redirect()->route('admin.subCategories')->with(['error' => 'هذا القسم غير موجود']);
            }
            isset($request->active) ? $active = 1 : $active = 0; // Set status 0 or 1
            /* update photo if exist  */
            if ($request->has('photo')) {
                ################ Begin delete this category image from project files ##########
                $local_path = str::before(app_path(), 'app');
                $img_path = Str::after($category->photo, 'assest/');
                $image = $local_path . "assest/" . $img_path;
                unlink($image); // delete the Image

                ################ End delete this category image from project files ##########
                $path = uploadImage('subCategory', $request->photo);
                $category->update([
                    'photo' => $path,
                ]);
            }
            /* update default language */
            $category->update([
                'name' => $request->name,
                'active' => $active,
            ]);
            $request_collection = collect($request->mainLang); // another languages in collectino from request
            if (isset($category->mainLang) && $category->mainLang()->count() > 0) { // loop inside languages if exist in database
                foreach ($category->mainLang as $category) {
                    $col = $request_collection->where('cat_id', $category->id); // which request category will insert
                    if ($col !== 'null') {
                        /*  get values from the request & update  */
                        foreach ($col as $colum) {
                            isset($colum['active']) ? $active = 1 : $active = 0;
                            $category->update([
                                'name' => $colum['name'],
                                'active' => $active,
                            ]);
                        }
                    } else {
                        return redirect()->route('admin.subCategories')->with(['error' => 'هذا القسم غير موجود']);
                    }
                }
            }
            DB::commit();
            return redirect()->route('admin.subCategories')->with(['success' => 'تم تعديل القسم بنجاح']);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.subCategories')->with(['error' => 'هناك خطأ ما']);
        }
    } // end of update method

    public function activation($id)
    {
        $category = SubCategory::find($id);
        if (!$category) {
            return redirect()->route('admin.subCategories')->with(['error' => 'هذا القسم غير موجود']);
        }
        $category = SubCategory::find($id);
        $cat_lang = $category->mainLang;
        if ($category->active !== 0) {
            $category->update(['active' => 0]);
            foreach ($cat_lang as $lang) {
                $lang->update(['active' => 0]);
            }
        } else {
            $category->update(['active' => 1]);
            foreach ($cat_lang as $lang) {
                $lang->update(['active' => 1]);
            }
        }
        return redirect()->route('admin.subCategories')->with(['success' => 'تم تعديل القسم بنجاح']);

    }


}
