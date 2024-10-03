
<style>
    .scroll-container {
        display: flex;
        gap: 1rem;
        overflow-x: auto;
        white-space: nowrap;
        scrollbar-width: thin;
        /* Untuk Firefox */
        scrollbar-color: #888 #f1f1f1;
        padding: 25px;
        /* Untuk Firefox */
    }

    .scroll-container::-webkit-scrollbar {
        height: 8px;
        
        /* Tinggi scrollbar */
    }

    .scroll-container::-webkit-scrollbar-thumb {
        background: #888;
        /* Warna scrollbar */
       
        border-radius: 10px;
        /* Membulatkan scrollbar */
    }

    .scroll-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        /* Warna track scrollbar */
    }
</style>
<div class="container mb-5">
    <div class="d-flex gap-4 scroll-container justify-content-center">
        {{$slot}}
    </div>
</div>


