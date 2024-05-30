<?php

namespace App\Http\Controllers\Backend\Admin\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller {
    public function index(): Response {
        Inertia::setRootView('admin');
        $categories = Category::all();
        return Inertia::render('Admin/Category/CategoryIndex', compact('categories'));
    }

    // Create Category Page  method
    public function create(): Response {
        Inertia::setRootView('admin');
        return Inertia::render('Admin/Category/Create');
    }

    // Category Store method
    public function store(Request $request) {
        $request->validate([
            'category_name' => 'required|string|max:50|unique:categories,category_name',
            'category_image' => 'required|mimes:jpg,png,webp|max:512',
        ]);
        $upload_file = $request->file('category_image');
        $file_extension = $upload_file->getClientOriginalExtension();
        $file_name = Str::lower(str_replace([' ', '.'], ['-', '-'], $request->category_name)) . "-" . time() . '.' . $file_extension;
        $path = $request->file('category_image')->storeAs('public/uploads/category', $file_name);
        $result = Category::insert([
            'category_name' => $request->category_name,
            'category_image' => $file_name,
            'created_at' => Carbon::now(),
        ]);
        if ($result == true) {

            return to_route('category.index')->with('success', 'Category created successfully.');

        } else {
            return back()->with('failed', 'Category Created Failed!');
        }
    }

    //  Category Delete Method
    public function destroy($category_id) {
        $category = Category::find($category_id);
        $category_img = public_path('storage/uploads/category/' . $category->category_image);
        $image_delete = unlink($category_img);
        if ($image_delete == true) {
            if ($category->delete() == true) {
                return back()->with('success', 'Category Deleted Successfully');
            } else {
                return back()->with('failed', 'Category Deleted Failed!');
            }
        } else {
            return back()->with('failed', 'Else Something Went Wrong!');
        }
    }

    // Category Edit Page method
    public function category_edit($category_id): Response {
        $category = Category::find($category_id);
        Inertia::setRootView('admin');
        return Inertia::render('Admin/Category/Edit', compact('category'));
    }

    // Category Update method
    public function category_update(Request $request, $category_id) {
        $request->validate([
            'category_name' => 'required|string|max:50|' . Rule::unique('categories', 'category_name')->ignore($category_id),
            //    'category_image' => 'required|mimes:jpg,png,webp|max:512',

        ]);
        if ($request->file('category_image') == '') {
            $category = Category::find($category_id);
            $result = $category->update([
                'category_name' => $request->category_name,
                'updated_at' => Carbon::now(),
            ]);
            if ($result == true) {
                return to_route('category.index')->with('success', 'Category Updated Successfully');
            } else {
                return back()->with('failed', 'Category Updated Failed!');
            }
        } else {
            $category = Category::find($category_id);
            $category_img = public_path('storage/uploads/category/' . $category->category_image);
            $image_delete = unlink($category_img);

            if ($image_delete == true) {
                $upload_file = $request->file('category_image');
                $file_extension = $upload_file->getClientOriginalExtension();
                $file_name = Str::lower(str_replace([' ', '.'], ['-', '-'], $request->category_name)) . "-" . time() . '.' . $file_extension;
                $path = $request->file('category_image')->storeAs('public/uploads/category', $file_name);
                $result = $category->update([
                    'category_name' => $request->category_name,
                    'category_image' => $file_name,
                    'updated_at' => Carbon::now(),
                ]);
                if ($result == true) {
                    return to_route('category.index')->with('success', 'Category Updated Successfully');
                } else {
                    return back()->with('failed', 'Category Updated Failed!');
                }
            }
        }
    }


}
