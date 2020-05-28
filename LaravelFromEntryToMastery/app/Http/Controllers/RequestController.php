<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SubmitFormRequest;
use App\Models\user_info;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{

    //Request对象实例可以访问所有用户请求数据，不管什么方式什么格式
    public function form(SubmitFormRequest $request)
    {
//        dd($request->input('books'));
//        dd($request->input('name'));
//        dd($id);
//        dd($request->get('books'));
//        return $data;
//        dd($request->all());

//        $this->validate($request, [
//            'title' => 'bail|required|string|between:2,32',
//            'url' => 'sometimes|url|max:200',
//            'picture' => 'nullable|string'
//        ]);

        return response('表单验证通过');
    }


    public function formatArray()
    {
        //$dataArray = DB::table('user_info')->select()->pluck('name','id');

//        $dataArray= DB::table('user_info')->where('id','<=','10')->orWhere(function ($query){
//                        $query->where('sex',2)->where('education','>','1');
//                    })->get()->toArray();

//        $resultData = user_info::findOrFail(1);
//        $resultData->delete();
//        if ($resultData->trashed()){
//            return '记录已经删除';
//        }
//        $dataArray = user_info::findOrFail(1);

        //获取软删除的方法
        $dataArray = user_info::onlyTrashed()->get();

        return $dataArray;

    }
}
