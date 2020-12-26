<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\EducationInternship;
use Image;

class EducationInternshipsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Education & Internship';
        $data['menu'] = 'giving_back';
        $data['sub_menu'] = 'education_internship';
        $data['lists'] = EducationInternship::orderBy('sort', 'asc')->get();
        return view('backend.education_internship', $data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = new EducationInternship();
            $data->title = $request->title;
            $data->desc = $request->desc;
            $maximum_sort_get = EducationInternship::orderBy('sort', 'desc')->first();
            if ($maximum_sort_get) {
                $data->sort = $maximum_sort_get->sort + 1;
            } else {
                $data->sort = 1;
            }

            if ($request->file('image')) {
                $image = $request->file('image');
                $file_name = uniqid() . '.' . $image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/Education', $image, $file_name);
            //   $destinationPath    = 'storage/app/public/uploads/education/';
            //   Image::make($image->getRealPath())
            //   // original
            //   ->save($destinationPath.$file_name)
            //   // thumbnail
            //   ->resize(428,285)
            //   ->save($destinationPath.'thumb'.$file_name)
            //   // resize
            //   ->resize(112,74) // set true if you want proportional image resize
            //   ->save($destinationPath.'resize'.$file_name)
            //   ->destroy();
            } else {
                $file_name = null;
            }
            $data->image = $file_name;
            $data->save();

            $notification = [
                'messege' => 'Successfully Save',
                'alert-type' => 'success',
            ];
            return Redirect()
                ->back()
                ->with($notification);
        } catch (ModelNotFoundException $e) {
            $notification = [
                'messege' => 'Sorry!',
                'alert-type' => 'error',
            ];
            return Redirect()
                ->back()
                ->with($notification);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function image_update(Request $request)
    {
        try {
            $data = EducationInternship::find($request->ourExpertise_id);

            if ($request->file('image')) {
                $image = $request->file('image');
                // old file remove
                if ($data->image) {
                    if (Storage::disk('public')->exists('uploads/Education/' . $data->image)) {
                        Storage::disk('public')->delete('uploads/Education/' . $data->image);
                    }
                }
                $file_name = uniqid() . '.' . $image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/Education', $image, $file_name);
                $data->image = $file_name;
            }

            $data->save();
            $notification = [
                'messege' => 'Successfully Image Updated',
                'alert-type' => 'success',
            ];
            return Redirect()
                ->back()
                ->with($notification);
        } catch (ModelNotFoundException $e) {
            $notification = [
                'messege' => 'Sorry!',
                'alert-type' => 'error',
            ];
            return Redirect()
                ->back()
                ->with($notification);
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data = EducationInternship::find($id);
            $data->title = $request->title;
            $data->desc = $request->desc;
            $data->save();
            $notification = [
                'messege' => 'Successfully Updated',
                'alert-type' => 'success',
            ];
            return Redirect()
                ->back()
                ->with($notification);
        } catch (ModelNotFoundException $e) {
            $notification = [
                'messege' => 'Sorry!',
                'alert-type' => 'error',
            ];
            return Redirect()
                ->back()
                ->with($notification);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = EducationInternship::find($id);
            if ($data->image) {
                if (Storage::disk('public')->exists('uploads/Education/' . $data->image)) {
                    Storage::disk('public')->delete('uploads/Education/' . $data->image);
                }
            }
            $data->delete();
            $notification = [
                'messege' => 'Successfully delete',
                'alert-type' => 'success',
            ];
            return Redirect()
                ->back()
                ->with($notification);
        } catch (ModelNotFoundException $e) {
            $notification = [
                'messege' => 'Sorry!',
                'alert-type' => 'error',
            ];
            return Redirect()
                ->back()
                ->with($notification);
        }
    }
    /**
     * for update sorting
     */
    public function sort_update(Request $request)
    {
        $this->validate($request, [
            'sort' => 'required',
            'id' => 'required',
        ]);

        //sort update
        $mainData = EducationInternship::find($request->id);
        $mainData->sort = $request->sort;
        if ($mainData) {
            $maximum_sort_get = EducationInternship::orderBy('sort', 'desc')->first();
            if ($maximum_sort_get->sort < $request->sort) {
                $mainData->sort = $request->sort;
            } elseif ($maximum_sort_get->sort > $request->sort) {
                $between_data_get = EducationInternship::whereBetween('sort', [$request->sort, $maximum_sort_get->sort])
                    ->orderBy('sort', 'asc')
                    ->get();
            } else {
                $between_data_get = EducationInternship::whereBetween('sort', [$maximum_sort_get->sort, $request->sort])
                    ->orderBy('sort', 'asc')
                    ->get();
            }
        } else {
            $notification = [
                'messege' => 'Did Not Updated!',
                'Sorry!',
                'alert-type' => 'error',
            ];
            return Redirect()
                ->back()
                ->with($notification);
        }

        if ($between_data_get->count() > 0) {
            foreach ($between_data_get as $key => $value) {
                if ($value->id != $mainData->id) {
                    $value->sort = $request->sort + ($key + 1);
                    $value->save();
                }
            }
        }
        $mainData->save();
        $notification = [
            'messege' => 'Successfully Save',
            'alert-type' => 'success',
        ];
        return Redirect()
            ->back()
            ->with($notification);
    }
}
