<script>
function uploadImagesSummernote(files, selector, folder) {
    let data = new FormData();
    for (let i = 0; i < files.length; i++) {
        data.append("images[]", files[i]);
    }

    data.append('folder', folder);

    $.ajax({
        url: '{{ route("summernote.upload") }}',
        method: 'POST',
        data: data,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(urls) {
            urls.forEach(function(url) {
                $(selector).summernote('insertImage', url);
            });
        },
        error: function(xhr) {
            alert("Upload gagal: " + xhr.responseText);
        }
    });
}

function deleteImageSummernote(imageUrl, folder) {
    $.ajax({
        url: '{{ route("summernote.delete") }}',
        method: 'POST',
        data: { 
            image_url: imageUrl,
            folder: folder,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            console.log('image deleted:', response);
        },
        error: function(xhr) {
            console.error('Gagal menghapus gambar:', xhr.responseText);
        }
    });
}

function extractImagesFromHtml(html) {
    let div = document.createElement("div");
    div.innerHTML = html;
    let imgs = Array.from(div.querySelectorAll("img"));
    return imgs.map(img => img.src);
}
</script>