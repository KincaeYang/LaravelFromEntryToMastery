# Laravel



## 路由

>  捕获任何方式的路由



```php
Route::any('/',function(){	});

# 从安全角度说，并不推荐上述这种路由定义方式，但是兼顾到便利性，我们可以通过 Route::match 指定请求方式白名单数组，比如下面这个路由可以匹配 GET 或 POST 请求：

Route::match(['get','post'], '/', function(){	});
```



## 路由参数

> 必填的和可选的路由参数



```php
# 必填
Route::get('/user/{id}',function( $id ){
	return '用户的ID：'.$id;
});


# 可选
Route::get('/user/{id?}',function( $id = 1){
	return '用户的ID：'.$id;
});
```



> 为路由参数指定正则匹配规则



```php
Route::get('page/{id}', function ($id) {
    return '页面ID: ' . $id;
})->where('id', '[0-9]+');


Route::get('page/{name}', function ($name) {
    return '页面名称: ' . $name;
})->where('name', '[A-Za-z]+');


Route::get('page/{id}/{slug}', function ($id, $slug) {
    return $id . ':' . $slug;
})->where(['id' => '[0-9]+', 'slug' => '[A-Za-z]+']);
```



> 访问路由



```php
Route::get('/', function(){	});

# 访问上面这条路由可参考下面的方法
<a href="{{ url('/') }}">点击访问</a>
```



## 路由命名



```php
# 在原来路由定义的基础上以方法链的形式新增一个 name 方法调用即可：

Route::get('user/{id?}', function ($id = 1) {
    return "用户ID: " . $id;
})->name('user.profile');


# 这样一来，不必显式引用路径 URL 就可以对路由进行引用;即使你调整了路由路径，只要路由名称不变，那么就无需修改前端视图代码

<a href="{{ route('user.profile',]['id'=>'100']) }}">点击访问</a>
# 输出：http://blog.test/user/100
    
# 以上路由可以简化为
<a href="{{ route('user.profile',]['100']) }}">点击访问</a>   
# 这样调用的话，数组中的参数顺序必须与定义路由时的参数顺序保持一致，而使用关联数组的方式传递参数则没有这样的约束
```



> 函数url和route的区别



```php
url 		中填写的是路径
route 		中填写的是路由名称
```





## 路由分组

> 通常将具有某些共同特征的路由进行分组，这些特征包括是否需要认证、是否具有共同的路由前缀或者子域名、以及是否具有相同的控制器命名空间等



```php
# 路由认证
Route::middleware('auth')->group(function(){
	
	Route::get('dashboard',function(){
		return view('dashboard');
	});
	
	Route::get('account', function () {
        return view('account');
    });
    
});

# 多个中间件的操作方式
Route::middleware(['auth','another'])->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    });
    Route::get('account', function () {
        return view('account');
    });
});
```



> 路由路径前缀



```php
# 路由拥有共同的路径前缀，可以使用 Route::prefix 为这个分组路由指定路径前缀并对其进行分组

Route::prefix('api')->group(function () {
    
    Route::get('/', function () {
        
    })->name('api.index');
    
    Route::get('users', function () {
        
    })->name('api.users');
});	
```



> 子命名空间



```php
# 默认的命名空间是 App\Http\Controllers；假设方法在这个控制器中 App\Http\Controllers\Admin\AdminController


Route::namespace('Admin')->group(function() {
     
     Route::get('/admin', 'AdminController@index');
});
```





> 路由命名前缀（路由命名+路径前缀）

```php
Route::name('user.')->prefix('user')->group(function () {
    
    Route::get('{id?}', function ($id = 1) {
        
        
        return route('user.show');			// 处理 /user/{id} 路由，路由命名为 user.show
    })->name('show');
    
    
    Route::get('posts', function () {
        
        
    })->name('posts');					    // 处理 /user/posts 路由，路由命名为 user.posts
});
```

