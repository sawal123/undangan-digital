/**
 * PRINCESS FAIRYTALE BIRTHDAY — pengaturan data demo.
 * Ubah nilai di bawah untuk membuat undangan milik anak Anda.
 * Semua gambar berada di assets/images/. RSVP dan ucapan masih mode preview localStorage.
 * Backend Laravel dapat menggantikan data ini melalui Blade/JSON dengan validasi dan escaping.
 */
window.INVITATION_CONFIG = {
  childName: 'Alenna Elise',
  childNickname: 'Alenna',
  turningAge: 2,
  childPhoto: 'assets/images/child-photo.webp',
  familyName: "Alenna's Family",
  // Gunakan ISO 8601 + zona waktu lokasi acara. Saat ini demo Jumat, 23 Okt 2026.
  eventDate: '2026-10-23T14:00:00+08:00',
  eventTimeZone: 'Asia/Manila',
  eventTimeLabel: '2:00 PM onwards',
  venueName: 'Sky Hall · Seaside City',
  address: 'Cebu South Coastal Road, Cebu City, Philippines',
  mapsQuery: 'Sky Hall Seaside City Cebu City',
  dressCode: 'Pastel Pink · Lilac · Cream',
  music: { src: 'assets/audio/fairy-lullaby.wav', enabled: true, startSeconds: 0 },
  schedule: [
    { time: '2:00 PM', name: 'Welcome to the castle', detail: 'A little hello & precious photos', icon: '✿' },
    { time: '2:30 PM', name: 'Fairy-tale fun', detail: 'Games, giggles & sweet surprises', icon: '✧' },
    { time: '3:15 PM', name: 'Make a wish', detail: 'Birthday song, candle & cake', icon: '♡' },
    { time: '4:00 PM', name: 'Happily ever after', detail: 'A sweet goodbye & party favors', icon: '♛' }
  ],
  gallery: [
    { src: 'assets/images/child-photo.webp', caption: 'Our little princess', alt: 'Potret putri kecil', shape: 'portrait' },
    { src: 'assets/images/garden.svg', caption: 'A magical little world', alt: 'Taman pastel penuh bunga', shape: 'square' },
    { src: 'assets/images/castle.svg', caption: 'A castle of dreams', alt: 'Ilustrasi kastel dongeng', shape: 'square' },
    { src: 'assets/images/carriage.svg', caption: 'And a little fairy dust', alt: 'Ilustrasi kereta kuda kerajaan', shape: 'portrait' }
  ],
  // Kosongkan contoh ucapan jika tidak ingin ada pesan contoh.
  sampleWishes: [
    { name: 'Your Fairy Godmother', message: 'May your days always be filled with sunshine, love and little bits of magic. Happy birthday! ✨' },
    { name: 'Auntie & Uncle', message: 'Wishing our beautiful little princess the sweetest birthday ever. Keep shining, Alenna! 💗' }
  ],
  gift: {
    bankName: 'BANK CONTOH',
    accountNumber: '0000000000',
    accountHolder: 'Nama Orang Tua',
    demo: true,
    shippingAddress: ''
  }
};
