<br>

<div class="form-group">
    <div class="fg-line">
        <label class="fg-label">Title</label>
        <input type="text" class="form-control" name="title" id="title"
               value="{{ !empty($title) ? $title : old('title', '') }}" placeholder="Title">
    </div>
</div>

<br>

<div class="form-group">
    <div class="fg-line">
        <label class="fg-label">Subtitle</label>
        <input type="text" class="form-control" name="subtitle" id="subtitle"
               value="{{ !empty($subtitle) ? $subtitle : old('subtitle', '') }}" placeholder="Subtitle">
    </div>
</div>

<br>

<div class="form-group">
    <div class="fg-line">
        <label class="fg-label">Page Image</label>
        <input type="text" class="form-control" name="page_image" id="page_image" onchange="handle_image_change()"
               alt="Image thumbnail" value="{{ !empty($page_image) ? $page_image : old('page_image', '') }}"
               placeholder="Page Image">
    </div>
</div>

<script>
    function handle_image_change() {
        $("#page-image-preview").attr("src", function () {
            var value = $("#page_image").val();
            if (!value) {
                value = {!! json_encode(config('blog.page_image')) !!};
                if (value == null) {
                    value = '';
                }
            }
            if (value.substr(0, 4) != 'http' && value.substr(0, 1) != '/') {
                value = {!! json_encode(config('blog.uploads.webpath')) !!} +'/' + value;
            }
            return value;
        });
    }
</script>
<div class="visible-sm space-10"></div>
@if (empty($page_image))
    <span class="text-muted small">No Image Selected</span>
@else
    <img src="{{ $page_image }}" class="img img_responsive" id="page-image-preview" style="max-height:40px">
@endif

<br>
<br>

<div class="form-group">
    <div class="fg-line">
        <textarea id="editor" name="content"
                  placeholder="Content">{{ !empty($content) ? $content : old('content', '') }}</textarea>
    </div>
</div>

<br>

<div class="form-group">
    <div class="fg-line">
        <label class="fg-label">Publish Date / Time</label>
        <input class="form-control datetime-picker" name="published_at" id="published_at" type="text"
               value="{{ !empty($published_at) ? $published_at : old('published_at', '') }}"
               placeholder="YYYY/MM/DD HH:MM:SS" data-mask="0000/00/00 00:00:00">
    </div>
</div>

<br>

<div class="checkbox m-b-15">
    <label>
        <input {{ !empty($is_draft) && checked($is_draft) }} type="checkbox" name="is_draft">
        <i class="input-helper"></i>
        Draft?
    </label>
</div>

<br>

<div class="form-group">
    <div class="fg-line">
        <label class="fg-label">Tags</label>
        <select name="tags[]" id="tags" class="selectpicker" multiple>
            @forelse($tags as $tag)
                <option @if (in_array($tag, $tags)) selected @endif value="{{ $tag }}">{{ $tag }}</option>
            @empty
                <option value="">-----</option>
            @endforelse
        </select>
    </div>
</div>

<br>

<div class="form-group">
    <div class="fg-line">
        <label class="fg-label">Layout</label>
        <input type="text" class="form-control" name="layout" id="layout"
               value="{{ !empty($layout) ? $layout : old('layout', '') }}" placeholder="Layout">
    </div>
</div>

<br>

<div class="form-group">
    <label class="fg-label">Meta Description</label>
    <div class="fg-line">
        <textarea class="form-control auto-size" name="meta_description" id="meta_description" style="resize: vertical"
                  placeholder="Meta Description">{{ !empty($meta_description) ? $meta_description : old('meta_description', '') }}</textarea>
    </div>
</div>