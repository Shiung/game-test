{{-- Create Folder Modal --}}
<div class="modal fade" id="modal-folder-create">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="{{ route('admin.folder.create') }}"
            class="form-horizontal">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="folder" value="{{ $folder }}">
        <div class="modal-header">

          <h4 class="modal-title">新增資料夾</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="new_folder_name" class="col-sm-3 control-label">
              資料夾名稱
            </label>
            <div class="col-sm-8">
              <input type="text" id="new_folder_name" name="new_folder"
                     class="form-control">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">
            取消
          </button>
          <button type="submit" class="btn btn-primary">
            新增
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Delete File Modal --}}
<div class="modal fade" id="modal-file-delete">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title">確認操作</h4>
      </div>
      <div class="modal-body">
        <p class="lead">
          <i class="fa fa-question-circle fa-lg"></i>  
          確認刪除
          <kbd><span id="delete-file-name1">file</span></kbd>
          ?
        </p>
      </div>
      <div class="modal-footer">
        <form method="POST" action="{{ route('admin.file.delete') }}">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="_method" value="DELETE">
          <input type="hidden" name="folder" value="{{ $folder }}">
          <input type="hidden" name="del_file" id="delete-file-name2">
          <button type="button" class="btn btn-default" data-dismiss="modal">
            取消
          </button>
          <button type="submit" class="btn btn-danger">
            確認
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Delete Folder Modal --}}
<div class="modal fade" id="modal-folder-delete">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title">確認操作</h4>
      </div>
      <div class="modal-body">
        <p class="lead">
          <i class="fa fa-question-circle fa-lg"></i>  
          確認刪除
          <kbd><span id="delete-folder-name1">folder</span></kbd>
          ?
        </p>
      </div>
      <div class="modal-footer">
        <form method="POST" action="{{ route('admin.folder.delete') }}">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="_method" value="DELETE">
          <input type="hidden" name="folder" value="{{ $folder }}">
          <input type="hidden" name="del_folder" id="delete-folder-name2">
          <button type="button" class="btn btn-default" data-dismiss="modal">
            取消
          </button>
          <button type="submit" class="btn btn-danger">
            確認
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Upload File Modal --}}
<div class="modal fade" id="modal-file-upload">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="{{ route('admin.file.upload') }}"
            class="form-horizontal" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="folder" value="{{ $folder }}">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            ×
          </button>
          <h4 class="modal-title">上傳檔案</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="file" class="col-sm-3 control-label">
              檔案
            </label>
            <div class="col-sm-8">
              <input type="file" id="file" multiple="multiple" name="file[]">
            </div>
          </div>
          <div class="form-group" style="display:none;">
            <label for="file_name" class="col-sm-3 control-label">
              重新命名
            </label>
            <div class="col-sm-4">
              <input type="text" id="file_name" name="file_name"
                     class="form-control">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">
            取消
          </button>
          <button type="submit" class="btn btn-primary">
            確認
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- View Image Modal --}}
<div class="modal fade" id="modal-image-view">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">圖片預覽</h4>
      </div>
      <div class="modal-body">
        <img id="preview-image" src="" class="img-responsive">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">
          關閉
        </button>
      </div>
    </div>
  </div>
</div>