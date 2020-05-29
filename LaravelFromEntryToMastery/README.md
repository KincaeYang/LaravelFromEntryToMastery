# Laravel

# 路由  



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
![控制器概述](C:\Users\yi\Desktop\控制器概述.png)# 默认的命名空间是 App\Http\Controllers；假设方法在这个控制器中 App\Http\Controllers\Admin\AdminController


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



# 控制器

![控制器概述](C:\Users\yi\Desktop\控制器概述.png)



`控制器概述`

​	控制器的主要职责就是获取 HTTP 请求，进行一些简单处理（如验证）后将其传递给真正处理业务逻辑的职能部门，如 Service

​	

## 获取用户输入

```php
Route::get('task/create', 'TaskController@create');
Route::post('task', 'TaskController@store');


public function store(Request $request)
{
    $task = new Task();
    $task->title = $request->input('title');
    $task->description = $request->input('description');
    $task->save();
    return redirect('task');   // 重定向到 GET task 路由
}

# 这里我们用到了 Eloquent 模型类 Task 和重定向方法 redirect()，我们将用户提交数据收集起来，保存到 Task 模型类，然后将用户重定向到显示所有任务的页面。这里我们通过 $request 对象来获取用户输入，此外还可以通过 Input 门面 获取用户输入：
$task->title = Input::get('title');

# 注意
# 门面仅仅是静态代理，底层调用的还是 $request->input 方法，建议用 $request 来获取。使用上述获取方式可以获取用户提供的任何输入数据，不管是查询字符串还是表单字段。
```



## **资源控制器方法列表**

| HTTP请求方式 | URL            | 控制器方法 | 路由命名    | 业务逻辑描述                 |
| ------------ | -------------- | ---------- | ----------- | ---------------------------- |
| GET          | post           | index()    | post.index  | 展示所有文章                 |
| GET          | post/create    | create()   | post.create | 发布文章表单页面             |
| POST         | post           | store()    | post.store  | 获取表单提交数据并保存新文章 |
| GET          | post/{post}    | show()     | post.show   | 展示单个文章                 |
| GET          | post/{id}/edit | edit()     | post.edit   | 编辑文章表单页面             |
| PUT          | post/{id}      | update()   | post.update | 获取编辑表单输入并更新文章   |
| DELETE       | post/{id}      | destroy()  | post.desc   | 删除单个文章                 |



## 路由模型绑定



### 隐式绑定



定义路由参数的时候，将参数设为唯一标识的变量（一般使用模型名称）。然后在闭包函数中，进行传入参数类型限制（依赖注入），这里的参数需要和路由中的参数名称保持一致。

```php
# 例子
Route::get('task/{task}', function (\App\Models\Task $task) {
    
    dd($task); // 打印 $task 明细
    
});

# laravel的底层默认传入的参数为模型Task的主键，查询获取对应模型实例，并将结果传递到闭包函数或控制器方法中。

# 该例子参见 web.php22行
```



> 路由绑定默认传输的参数是主键，也可以手动在该模型内，进行修改。如下所示

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function getRouteKeyName() {
        return 'name';  // 以任务名称作为路由模型绑定查询字段
    }
}
```



### 显示绑定



> 显式绑定需要手动配置路由模型绑定，通常需要在 `App\Providers\RouteServiceProvider` 的 `boot()` 方法中新增如下这段配置代码：



```php
public function boot()
{
    // 显式路由模型绑定
    Route::model('task_model', Task::class);

    parent::boot();
}
```



> 编写完这段代码后，以后每次访问包含 `{task_model}` 参数的路由时，路由解析器都会从请求 URL 中解析出模型 ID ，然后从对应模型类 `Task` 中获取相应的模型实例并传递给闭包函数或控制器方法：



```php
Route::get('task/model/{task_model}', function (\App\Models\Task $task) {
    dd($task);
});
```



### 兜底路由

> 路由文件中定义的所有路由都无法匹配用户请求的 URL 时，用来处理用户请求的路由。使用兜底路由的好处是我们可以对这类请求进行统计并进行一些自定义的操作，比如重定向，或者一些友好的提示什么的

```php
# 兜底路由通过 Route::fallback 来定义
    
Route::fallback(function () {
    return '我是最后的屏障';
});   
```



### 频率限制

> 在规定时间该用户对某个路由的访问次数限制



使用场景：

1.  某些需要认证的页面，限制用户失败的次数，提高系统的安全性

 	2. 避免非正常用户（比如爬虫）对路由的过度频繁访问，从而提高系统的可用性
 	3. 在流量高峰期还可以借助此功能进行有效的限流



```php
# 在 Laravel 中该功能通过内置的 throttle 中间件来实现，该中间件接收两个参数，第一个是次数上限，第二个是指定时间段（单位：分钟）
Route::middleware('throttle:60,1')->group(function () {
    Route::get('/user', function () {
        //
    });
});

# 以上路由的含义是一分钟能只能访问路由分组的内路由（如 /user）60 次，超过此限制会返回 429 状态码并提示请求过于频繁。
```



> 还可以通过模型属性来动态设置频率，例如，我们可以为上述通过 `throttle` 中间件进行分组的路由涉及到的模型类定义一个 `rate_limit` 属性，然后这样来动态定义这个路由：

```php
Route::middleware('throttle:rate_limit,1')->group(function () {
    Route::get('/user', function () {
        // 在 User 模型中设置自定义的 rate_limit 属性值
    });
    Route::get('/post', function () {
        // 在 Post 模型中设置自定义的 rate_limit 属性值
    });
});

# 代码参考web.php 26行
```



## 跨站请求伪造



> 如果路由执行的是写入操作，则需要传入一个隐藏的token字段，以避免  跨站请求伪造攻击  (CSRF)


## 视图返回与参数传递

```php
    return view('home')->with('tasks', Task::all());
    
    # 或者（推荐使用后者，因为简单）
    return view('home', ['tasks' => Task::all()]);
```


## 视图间共享变量

> 在不同视图间传递同一个数据变量,通过视图对象提供的 share 方法实现，
> 在某个服务提供者如 AppServiceProvider 的 boot 方法中定义共享的视图变量：

```php
    view()->share('siteName', 'Laravel学院');
    view()->share('siteUrl', 'https://xueyuanjun.com');
```



# Blade模板

Blade常见的三种语法：

	1. 通过	{{	}}	渲染PHP变量
 	2. 通过    {!!   !!}    渲染原生HTML代码
 	3. 通过以@为前缀的Blade指令执行一些控制结构和继承、引入之类的操作



列子：{{ $variable }} 	

通过	{{	}}	包裹需要渲染的php变量。通过 `{{}}` 语法包裹渲染的 PHP 变量会通过 `htmlentities()` 方法进行 HTML 字符转义，从而避免类似 XSS 这种攻击，提高了代码的安全性

所以 `{{ $variable }}` 编译后的最终代码是：

```php
<?php echo htmlentities($variable); ?>
```



某些情况下不能对变量中 HTML 字符进行转义，比如我们在表单通过富文本编辑器编辑后提交的表单数据，这种场景就需要通过 `{!! !!}` 来包裹待渲染数据了：

```php
{!! $variable !!}
```



如果要注释一段 PHP 代码，可以通过 `{{-- 注释内容 --}}` 实现。



# 控制结构



## @unless



`@unless`是blade 提供的一个PHP中没有的语法

```php
@unless($boy)可以理解为	if(!$boy): 然后以@endunless收尾
   
例如    
@unless ($user->hasPaid())
		
@endunless
```



## @switch



```php
@switch($i)
    @case(1)
        // $i = 1 做什么
        @break

    @case(2)
        // $i = 2 做什么
        @break

    @default
        // 默认情况下做什么
@endswitch
```



## @循环



```php
// for 循环
@for ($i = 0; $i < $talk->slotsCount(); $i++) 
    The number is {{ $i }}<br> 
@endfor

// foreach 循环
@foreach ($talks as $talk)
    {{ $talk->title }} ({{ $talk->length }} 分钟)<br> 
@endforeach

// while 循环  
@while ($item = array_pop($items)) 
    {{ $item->orSomething() }}<br> 
@endwhile
```



## @forelse

```php
<?php 
if ($students) {
    foreach ($students as $student) {
       // do something ...
    }
} else {
    // do something else ...
}

等价于：
    
@forelse ($students as $student)
    // do something ...
@empty
    // do something else ...
@endforelse    
```



## $loop

在循环控制结构中，我们要重磅介绍的就是 Blade 模板为 `@foreach` 和 `@forelse` 循环结构提供的 `$loop` 变量了，通过该变量，我们可以在循环体中轻松访问该循环体的很多信息，而不用自己编写那些恼人的面条式代码，比如当前迭代索引、嵌套层级、元素总量、当前索引在循环中的位置等，`$loop` 实例上有以下属性可以直接访问：

| 属性             | 描述                        |
| ---------------- | --------------------------- |
| $loop->index     | 当前循环迭代索引（从0开始） |
| $loop->iteration | 当前循环迭代（从1开始）     |
| $loop->remaining | 当前循环剩余的迭代          |
| $loop->count     | 迭代数组元素的总数量        |
| $loop->first     | 是否当前循环的第一个迭代    |
| $loop->last      | 是否当前循环的最后一个迭代  |
| $loop->depth     | 当前循环的嵌套层级          |
| $loop->parent    | 嵌套循环中的父级循环变量    |



# 请求处理篇



> 判断是否包含指定字段



```php
# exists 方法是 has 方法的别名，两者调用方式一样，功能完全等效。

$id = $request->has('id') ? $request->get('id') : 0;


# 获取指定字段的值，以及设置默认值

$site = $request->input('site', 'Laravel学院');
```



## Laravel中request::input和get有什么区别？

两个函数都可以用来接受值，但是有时候get会接受不到。推荐使用input()





# 分页

> 通过skip()和take()方法进行组合分页；skip表示从第几条数据开始，take表示一次获取多少条数据

​	

```php
$post = DB::table()->orderBy()->where()->skip()->take()->get()
```



# 批量赋值、更新

> 以数组的形式将需要设置的属性以关联数组的方式传递构造函数

```php
$post = new Post([
    'title' => '测试文章标题', 
    'content' => '测试文章内容'
]);

# 仅这么看的话，好像跟之前的写法没有什么大的优势，还是需要指定每个属性，但是这为我们提供了一个很好的基础，如果和用户请求数据结合起来使用，就能焕发它的光彩了。比如，如果我们的请求数据是一个文章发布表单提交过来的数据，包含 title、content 等字段信息，就可以通过下面这种方式进行批量赋值了：

$post = new Post($request->all());

# 更新模型类，也可以通过批量赋值的方式实现，只需在获取模型类后使用 fill 方法批量填充属性即可：
$post = Post::findOrFail(11);
$post->fill($request->all());
$post->save();
```



# 白名单、黑名单



**白名单**

​	所谓白名单属性就是该属性中指定的字段才能应用批量赋值，不在白名单中的属性会被忽略



**黑名单**

​	黑名单属性指定的字段不会应用批量赋值，不在黑名单中的属性则会应用批量赋值

```php
/**
 * 使用批量赋值的属性（白名单）
 *
 * @var array
 */
protected $fillable = [];

/**
 * 不使用批量赋值的字段（黑名单）
 *
 * @var array
 */
protected $guarded = ['*'];
```



# 软删除

> 实现步骤

```php
# 创建迁移文件

php artisan make:migration alter_posts_add_deleted_at --table=posts
    
# 在迁移文件中执行如下操作    
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPostsAddDeletedAt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            //重点是这条
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
    }
}

# 然后在模型类中做相应的修改
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//重点
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    //重点
    use SoftDeletes;

    protected $guarded = ['user_id'];
}


# 开始删除；
$post = Post::findOrFail(32);
$post->delete();
if ($post->trashed()) {
    dump('该记录已删除');
}


# 在查询结果中出现软删除记录，可以通过在查询的时候调用 withTrashed 方法实现：
$post = Post::withTrashed()->find(32);

# 获取被软删的记录
$post = Post::onlyTrashed()->where('views', 0)->get();

# 如果是误删除的话，你可以 restore 方法来恢复软删除记录：
$post->restore();   // 恢复单条记录
Post::onlyTrashed()->where('views', 0)->restore(); // 恢复多条记录

# 确实是想物理删除数据表记录，通过 forceDelete 方法删除即可：
$post->forceDelete();
```



# 访问器

> 访问器用于从数据库获取指定数据，经过处理后再返回给调用方



```PHP
# 在对应的模型中设置属性

public function getDisplayNameAttribute()
{
    return $this->nickname ? $this->nickname : $this->name;
}

# 设置好对应的属性后，只需要在控制器中调用实例化后的模型即可
$user = new User();
$user->display_level
```





