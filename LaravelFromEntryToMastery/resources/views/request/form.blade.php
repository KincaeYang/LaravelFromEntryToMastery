<form action="{{ route('form.submit') }}" method="POST">
    <div class="form-group">
        <label>标题</label>
        <input type="text" name="title" class="form-control" placeholder="输入标题">
    </div>
    <div class="form-group">
        <label>URL</label>
        <input type="text" name="url" class="form-control" placeholder="输入URL">
    </div>
    <fileupload-component></fileupload-component>
    <button type="submit" class="btn btn-primary">提交</button>
</form>