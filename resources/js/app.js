import './bootstrap';

    document.addEventListener('DOMContentLoaded', function() {
    const myFile = document.getElementById('myFile');
    const imgPreview = document.getElementById('imgpreview');
    const uploadFile = document.getElementById('upload-file');
    const previewImg = imgPreview.querySelector('img');
    const previewModal = document.getElementById('previewModal');
    const modalImg = previewModal.querySelector('img');
    const closeModal = previewModal.querySelector('.close-modal');
    const previewBtn = imgPreview.querySelector('.preview-btn');
    const deleteBtn = imgPreview.querySelector('.delete-btn');

    // File Upload Handler
    myFile.addEventListener('change', function(e) {
    const file = this.files[0];
    if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
    previewImg.src = e.target.result;
    modalImg.src = e.target.result;
    imgPreview.style.display = 'block';
    uploadFile.style.display = 'none';
};
    reader.readAsDataURL(file);
}
});

    // Delete Image Handler
    function deleteImage() {
    previewImg.src = '';
    modalImg.src = '';
    myFile.value = '';
    imgPreview.style.display = 'none';
    uploadFile.style.display = 'block';
    previewModal.classList.remove('active');
}

    deleteBtn.addEventListener('click', deleteImage);

    // Preview Modal Handlers
    previewBtn.addEventListener('click', function() {
    previewModal.classList.add('active');
});

    closeModal.addEventListener('click', function() {
    previewModal.classList.remove('active');
});

    previewModal.addEventListener('click', function(e) {
    if (e.target === previewModal) {
    previewModal.classList.remove('active');
}
});

    // Drag and Drop Handlers
    const dropZone = uploadFile.querySelector('.uploadfile');

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, preventDefaults, false);
});

    function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

    ['dragenter', 'dragover'].forEach(eventName => {
    dropZone.addEventListener(eventName, highlight, false);
});

    ['dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, unhighlight, false);
});

    function highlight(e) {
    dropZone.classList.add('highlight');
}

    function unhighlight(e) {
    dropZone.classList.remove('highlight');
}

    dropZone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
    const dt = e.dataTransfer;
    const file = dt.files[0];
    myFile.files = dt.files;

    if (file && file.type.startsWith('image/')) {
    const reader = new FileReader();
    reader.onload = function(e) {
    previewImg.src = e.target.result;
    modalImg.src = e.target.result;
    imgPreview.style.display = 'block';
    uploadFile.style.display = 'none';
};
    reader.readAsDataURL(file);
}
}

    // Slug generation from name
    document.querySelector('input[name="name"]').addEventListener('input', function() {
    const name = this.value;
    const slug = name.toLowerCase()
    .replace(/ /g, '-')
    .replace(/[^\w-]+/g, '');
    document.querySelector('input[name="slug"]').value = slug;
});
});
