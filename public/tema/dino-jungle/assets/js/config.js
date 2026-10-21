/**
 * DINO JUNGLE BIRTHDAY - DEMO CONFIGURATION
 * Semua data di bawah adalah contoh. Edit lalu publikasikan dengan data nyata.
 * Hubungkan form RSVP/ucapan ke backend Laravel ketika dipasang di undangan-digital.
 */
window.DINO_BIRTHDAY_CONFIG = {
  childName: 'Raka',
  childAge: 5,
  childPhoto: '', // opsional: 'assets/images/foto-anak.webp' atau URL HTTPS
  dateTimeISO: '2026-11-28T15:00:00+07:00',
  endDateTimeISO: '2026-11-28T18:00:00+07:00',
  timezone: 'Asia/Jakarta',
  timezoneAbbreviation: 'WIB',
  venue: 'Jungle Party House',
  address: 'Jl. Contoh No. 28, Medan (alamat demo)',
  mapsUrl: 'https://www.google.com/maps/search/?api=1&query=Medan%2C%20Sumatera%20Utara',
  hosts: 'Raka & Family',
  guestFallbackName: 'Teman Spesial',
  dressCode: 'Pakai baju favoritmu warna hijau, cokelat, atau kuning!',
  agenda: [
    {time: '15.00', emoji: '🌴', title: 'Welcome, Explorers!', description: 'Check-in, foto di jungle photo booth, dan cari jejak dino.'},
    {time: '15.30', emoji: '🦕', title: 'Dino Hunt & Games', description: 'Buru telur dinosaurus dan menangkan hadiah kejutan.'},
    {time: '16.30', emoji: '🎂', title: 'Roar-some Cake Time', description: 'Tiup lilin, nyanyikan lagu ulang tahun, dan makan kue.'},
    {time: '17.00', emoji: '🎁', title: 'Goodies & Goodbye!', description: 'Foto bersama, berbagi hadiah, dan pulang dengan cerita seru.'}
  ],
  gallery: [
    {src: 'assets/images/gallery-cake.svg', caption: 'Dino birthday cake'},
    {src: 'assets/images/gallery-balloons.svg', caption: 'Jungle party decorations'},
    {src: 'assets/images/gallery-hats.svg', caption: 'Explorer party hats'},
    {src: 'assets/images/gallery-gifts.svg', caption: 'Little surprises'}
  ],
  wishesSeed: [
    {name:'Keluarga Tersayang', message:'Selamat ulang tahun! Semoga tumbuh sehat, ceria, dan penuh keberanian untuk menjelajah dunia. 🦖'},
    {name:'Sahabat Dino', message:'Happy birthday! Semoga semua mimpimu sebesar dinosaurus! 🌿🎂'}
  ],
  gifts: {
    enabled: false, // aktifkan HANYA setelah informasi benar
    bankName: 'Bank Contoh',
    accountNumber: '0000000000',
    accountHolder: 'Nama Pemilik Rekening',
    deliveryAddress: '',
    qrisImage: ''
  },
  milestones: [], // opsional [{ year:'2024',emoji:'🥚',title:'First steps',detail:'...' }]
  birthdayVideo: { enabled:false, url:'' }, // URL/file .mp4 milik Anda
  streaming: { enabled:false, url:'' },
  instagramUrl: '',
  music: {enabled:true, startPlayingOnOpen:true}
};
