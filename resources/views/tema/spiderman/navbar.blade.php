<div class="navbar absolute bottom-3 w-full z-10" id="navbar">
    <div
      class="py-3 relative flex justify-center ring-1 ring-offset-2 ring-white text-white w-full h-auto bg-blue-700 shadow-lg">
      <div class="flex flex-row justify-center items-center w-full text-sm gap-3 text-white">
        <button class="nav-link opening flex items-center hover:bg-red-700 p-2 rounded-lg transition duration-200"
          onclick="showSection('opening', this)">
          <i class="fa-solid fa-house"></i>
          <span class="ml-2 hidden">Opening</span>
        </button>
        <button class="nav-link acara flex items-center hover:bg-red-700 p-2 rounded-lg transition duration-200"
          onclick="showSection('acara', this)">
          <i class="fa-solid fa-calendar"></i>
          <span class="ml-2 hidden">Acara</span>
        </button>
        <button class="nav-link gallery flex items-center hover:bg-red-700 p-2 rounded-lg transition duration-200"
          onclick="showSection('gallery', this)">
          <i class="fa-solid fa-images"></i>
          <span class="ml-2 hidden">Gallery</span>
        </button>
        <button class="nav-link rspv flex items-center hover:bg-red-700 p-2 rounded-lg transition duration-200"
          onclick="showSection('rspv', this)">
          <i class="fa-solid fa-comment"></i>
          <span class="ml-2 hidden">Rspv</span>
        </button>
        <button class="nav-link gift flex items-center hover:bg-red-700 p-2 rounded-lg transition duration-200"
          onclick="showSection('gift', this)">
          <i class="fa-solid fa-gift"></i>
          <span class="ml-2 hidden">Gift</span>
        </button>
        <button class="nav-link thanks flex items-center hover:bg-red-700 p-2 rounded-lg transition duration-200"
          onclick="showSection('thanks', this)">
          <i class="fa-solid fa-square-check"></i>
          <span class="ml-2 hidden">Thanks</span>
        </button>
      </div>
    </div>
  </div>