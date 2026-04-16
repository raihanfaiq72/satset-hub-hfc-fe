
<script>
const gallery = @json($galleryItems);
let currentZoomIndex = null;

function openZoom(index){
    currentZoomIndex = index;
    const modal = document.getElementById('zoomModal');
    const container = document.getElementById('mediaContainer');
    const caption = document.getElementById('mediaCaption');
    const item = gallery[index];

    caption.textContent = item.keterangan ?? '';

    if(item.type === 'image'){
        container.innerHTML = `<img src="${item.path}" class="w-full h-full object-contain">`;
    } else if(item.type === 'video'){
        container.innerHTML = `<video src="${item.path}" controls autoplay loop class="w-full h-full object-contain"></video>`;
    }

    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeZoom(){
    const modal = document.getElementById('zoomModal');
    const video = document.querySelector('#mediaContainer video');
    if(video){
        video.pause();
        video.currentTime = 0;
    }
    modal.classList.add('hidden');
    document.body.style.overflow = '';
    currentZoomIndex = null;
}

function nextZoom(){
    if(currentZoomIndex !== null){
        currentZoomIndex = (currentZoomIndex + 1) % gallery.length;
        openZoom(currentZoomIndex);
    }
}

function prevZoom(){
    if(currentZoomIndex !== null){
        currentZoomIndex = (currentZoomIndex - 1 + gallery.length) % gallery.length;
        openZoom(currentZoomIndex);
    }
}

document.addEventListener('keydown', function(e){
    if(currentZoomIndex !== null){
        if(e.key === 'Escape') closeZoom();
        else if(e.key === 'ArrowLeft') prevZoom();
        else if(e.key === 'ArrowRight') nextZoom();
    }
});

let touchStartX = 0;
let touchEndX = 0;

document.getElementById('zoomModal').addEventListener('touchstart', function(e){
    touchStartX = e.changedTouches[0].screenX;
});

document.getElementById('zoomModal').addEventListener('touchend', function(e){
    touchEndX = e.changedTouches[0].screenX;
    if(currentZoomIndex !== null){
        if(touchEndX < touchStartX - 50) nextZoom();
        if(touchEndX > touchStartX + 50) prevZoom();
    }
});
</script>