(() => {
  'use strict';
  const defaults = window.DINO_BIRTHDAY_CONFIG || {};
  const $ = (selector, root = document) => root.querySelector(selector);
  const $$ = (selector, root = document) => [...root.querySelectorAll(selector)];
  const str = (v, fallback = '') => (typeof v === 'string' && v.trim() ? v.trim() : fallback);
  const fallbackImage = str(defaults.fallbackImage, 'assets/images/gallery-gifts.svg');
  const clip = (value, max = 200) => String(value ?? '').slice(0, max).trim();
  const firstName = str(defaults.childName, 'Si Kecil').split(/\s+/)[0];
  const childName = str(defaults.childName, 'Si Kecil');
  const childAge = Math.max(0, Math.min(100, Number(defaults.childAge) || 0));
  const timezone = str(defaults.timezone, 'Asia/Jakarta');
  const tzShort = str(defaults.timezoneAbbreviation, 'WIB');
  const guestParam = new URLSearchParams(location.search);
  const guestName = clip(guestParam.get('to') || guestParam.get('nama') || defaults.guestFallbackName || 'Teman Spesial', 80) || 'Teman Spesial';
  const eventStart = new Date(defaults.dateTimeISO);
  const eventEnd = new Date(defaults.endDateTimeISO);
  const validDate = !Number.isNaN(eventStart.getTime());
  const localeDate = (options) => {
    if (!validDate) return 'Tanggal menyusul';
    try { return new Intl.DateTimeFormat('id-ID', {timeZone: timezone, ...options}).format(eventStart); }
    catch { return new Intl.DateTimeFormat('id-ID', options).format(eventStart); }
  };
  const formatTime = (date) => {
    if (!(date instanceof Date) || Number.isNaN(date.getTime())) return '';
    try { return new Intl.DateTimeFormat('id-ID', {timeZone: timezone, hour: '2-digit', minute: '2-digit', hour12: false}).format(date).replace(':', '.'); }
    catch { return new Intl.DateTimeFormat('id-ID', {hour: '2-digit', minute: '2-digit', hour12: false}).format(date).replace(':', '.'); }
  };
  function putAll(selector, value) { $$(selector).forEach(el => { el.textContent = String(value); }); }
  putAll('[data-child-name]', childName);
  putAll('[data-name-first]', `${firstName.toUpperCase()}'S`);
  putAll('[data-child-age]', childAge);
  putAll('[data-age-label]', `TURNING ${childAge}!`);
  putAll('[data-guest-name]', guestName);
  putAll('[data-hosts]', str(defaults.hosts, `${childName} & Family`));
  putAll('[data-venue]', str(defaults.venue, 'Tempat acara akan diumumkan'));
  putAll('[data-address]', str(defaults.address, 'Alamat akan diumumkan'));
  putAll('[data-dress-code]', str(defaults.dressCode, 'Kenakan pakaian yang nyaman untuk pesta!'));
  putAll('[data-date-short]', validDate ? localeDate({weekday:'short', day:'numeric',month:'short',year:'numeric'}).toUpperCase() : 'TANGGAL MENYUSUL');
  putAll('[data-event-date]', localeDate({weekday:'long', day:'numeric',month:'long',year:'numeric'}));
  putAll('[data-time-short]', validDate ? `${formatTime(eventStart)} ${tzShort}` : 'WAKTU MENYUSUL');
  putAll('[data-event-time]', validDate ? `${formatTime(eventStart)}${!Number.isNaN(eventEnd.getTime()) ? ' - ' + formatTime(eventEnd) : ''} ${tzShort}` : 'Waktu menyusul');
  const safeHttpUrl = (url) => { try { const parsed = new URL(str(url), location.href); return ['https:','http:'].includes(parsed.protocol) ? parsed.href : ''; } catch { return ''; } };
  const mapsUrl = safeHttpUrl(defaults.mapsUrl);
  const mapsLink = $('#maps-link');
  if (mapsUrl) mapsLink.href = mapsUrl;
  else { mapsLink.hidden = true; }
  const heroTitle = $('#main-title');
  document.title = `Dino Jungle Birthday — ${childName} Turns ${childAge}`;
  const toastElement = $('#toast');
  let toastTimer = null;
  function toast(message) {
    toastElement.textContent = message;
    toastElement.classList.add('show');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => toastElement.classList.remove('show'), 3200);
  }
  function readLocal(key) { try { return JSON.parse(localStorage.getItem(key) || 'null'); } catch { return null; } }
  const fallbackStore = {};
  function getStored(key) { return readLocal(key) ?? fallbackStore[key] ?? []; }
  function saveStored(key, data) { fallbackStore[key] = data; try { localStorage.setItem(key, JSON.stringify(data)); return true; } catch { return false; } }
  // Separate demo records by party identifier; never confuse with backend persistence.
  const storageScope = `dino-v1:${childName.toLowerCase()}:${defaults.dateTimeISO || 'no-date'}`;
  const rsvpKey = `${storageScope}:rsvp`, wishesKey = `${storageScope}:wishes`;
  const parsedList = key => { const val = getStored(key); return Array.isArray(val) ? val : []; };
  // Optional photo frame; hidden when no child photo is provided.
  if (str(defaults.childPhoto)) {
    const src = str(defaults.childPhoto);
    const allowed = safeHttpUrl(src) || (src.startsWith('assets/') ? src : '');
    if (allowed) {
      const frame = $('#child-photo-wrap'), photo = $('#child-photo');
      frame.hidden = false; photo.src = allowed; photo.alt = 'Foto ' + childName;
      photo.addEventListener('error', () => { frame.hidden = true; });
    }
  }
  if (firstName.length > 10) heroTitle.classList.add('very-long-name');
  else if (firstName.length > 7) heroTitle.classList.add('long-name');
  // Countdown is clamped so expired dates don't show negative values.
  function updateCountdown() {
    const total = validDate ? Math.max(0, eventStart.getTime() - Date.now()) : 0;
    const seconds = Math.floor(total / 1000);
    const parts = [Math.floor(seconds / 86400),Math.floor(seconds % 86400 / 3600),Math.floor(seconds % 3600 / 60),seconds % 60];
    ['cd-days','cd-hours','cd-minutes','cd-seconds'].forEach((id, i) => { const node = document.getElementById(id); if (node) node.textContent = String(parts[i]).padStart(2,'0'); });
    $('#countdown-caption').textContent = !validDate ? 'Tanggal acara akan segera diumumkan.' : total === 0 ? 'Hooray! Hari petualangan dinosaurus telah tiba atau berlalu! 🦕' : 'Siapkan sepatu petualangmu. Pestanya segera dimulai!';
  }
  updateCountdown();
  setInterval(updateCountdown, 1000);
  // Schedule cards: all content inserted via textContent to avoid script injection.
  const agendaList = $('#agenda-list');
  const agenda = Array.isArray(defaults.agenda) ? defaults.agenda : [];
  if (!agenda.length) { const p = document.createElement('p');p.className='section-caption';p.textContent='Rangkaian acara akan segera diumumkan.';agendaList.appendChild(p); }
  agenda.slice(0, 30).forEach(item => {
    if (!item || typeof item !== 'object') return;
    const row = document.createElement('div');row.className='agenda-item reveal';
    const emoji = document.createElement('div');emoji.className='agenda-emoji';emoji.textContent=clip(item.emoji || '🦕',8);
    const card = document.createElement('div');card.className='agenda-card';
    const time = document.createElement('span');time.className='agenda-time';time.textContent=clip(item.time,20);
    const title = document.createElement('strong');title.textContent=clip(item.title,90);
    const desc = document.createElement('p');desc.textContent=clip(item.description,350);
    card.append(time,title,desc);row.append(emoji,card);agendaList.appendChild(row);
  });
  // Images and lightbox: handle empty galleries and missing assets gracefully.
  const galleryGrid = $('#gallery-grid');
  const gallery = (Array.isArray(defaults.gallery) ? defaults.gallery : []).filter(x => x && typeof x === 'object' && str(x.src)).slice(0,30);
  if (!gallery.length) { const empty = document.createElement('div');empty.className='gallery-empty reveal';empty.textContent='Foto-foto petualangan akan segera hadir. 🌿';galleryGrid.appendChild(empty); }
  const lightbox = $('#lightbox');
  let previousFocus = null;
  function closeLightbox() { lightbox.hidden=true;document.body.style.overflow=''; if (previousFocus && typeof previousFocus.focus === 'function') previousFocus.focus(); }
  function showLightbox(src,caption,button) {
    previousFocus=button;$('#lightbox-image').src=src;$('#lightbox-image').alt=caption;$('#lightbox-caption').textContent=caption;lightbox.hidden=false;document.body.style.overflow='hidden';$('#lightbox-close').focus();
  }
  $('#lightbox-close').addEventListener('click',closeLightbox);
  lightbox.addEventListener('click',e=>{if(e.target===lightbox)closeLightbox();});
  document.addEventListener('keydown',e=>{ if(e.key==='Escape'&&!lightbox.hidden)closeLightbox(); if(e.key==='Tab'&&!lightbox.hidden){e.preventDefault();$('#lightbox-close').focus();}});
  gallery.forEach((item,index)=>{
    const b=document.createElement('button');b.type='button';b.className='gallery-item reveal';b.setAttribute('aria-label','Lihat foto: '+clip(item.caption||`Galeri ${index+1}`,90));
    const img=document.createElement('img');img.src=str(item.src);img.alt=clip(item.caption||`Foto galeri ${index+1}`,120);img.loading='lazy';
    img.addEventListener('error',()=>{if(img.src!==fallbackImage)img.src=fallbackImage;});
    const cap=document.createElement('span');cap.textContent=clip(item.caption||`Galeri ${index+1}`,80);
    b.append(img,cap);b.addEventListener('click',()=>showLightbox(img.currentSrc||img.src,cap.textContent,b));galleryGrid.appendChild(b);
  });
  // Client-side RSVP demo only. The server must revalidate when integrated with Laravel.
  const rsvpForm=$('#rsvp-form');
  const attendance=$('#rsvp-attendance');
  const countWrap=$('#rsvp-guest-count-wrap');
  const rsvpCount=$('#rsvp-count');
  if(rsvpForm&&attendance&&countWrap&&rsvpCount){
  const rsvpName=$('#rsvp-name');
  rsvpName.value=guestName===str(defaults.guestFallbackName,'Teman Spesial') ? '' : guestName;
  const wishNameInput=$('#wish-name');
  if(wishNameInput)wishNameInput.value=rsvpName.value;
  function toggleGuestCount(){ countWrap.hidden=attendance.value!=='yes';rsvpCount.disabled=attendance.value!=='yes'; }
  attendance.addEventListener('change',toggleGuestCount);toggleGuestCount();
  function updateRsvpTotal(){const total=parsedList(rsvpKey).reduce((acc,item)=>acc+(item?.attendance==='yes' ? Math.max(1,Math.min(5,Number(item.count)||1)):0),0);$('#rsvp-total').textContent=String(total);}
  updateRsvpTotal();
  if(defaults.backend?.rsvp===true){
  rsvpForm.addEventListener('submit',e=>{
    const name=clip(rsvpName.value,80);const attending=attendance.value;
    if(name.length<2){e.preventDefault();toast('Masukkan nama minimal 2 karakter.');rsvpName.focus();return;}
    if(!['yes','no'].includes(attending)){e.preventDefault();toast('Pilih konfirmasi kehadiran.');attendance.focus();return;}
    if(rsvpForm.elements.nama)rsvpForm.elements.nama.value=name;
    if(rsvpForm.elements.status)rsvpForm.elements.status.value=attending==='yes'?'hadir':'tidak_hadir';
    if(rsvpForm.elements.ucapan&&!rsvpForm.elements.ucapan.value.trim())rsvpForm.elements.ucapan.value='Konfirmasi kehadiran di pesta ulang tahun.';
  });
  }else rsvpForm.addEventListener('submit',e=>{
    e.preventDefault();
    const name=clip(rsvpName.value,80);const attending=attendance.value;
    if(name.length<2){toast('Masukkan nama minimal 2 karakter.');rsvpName.focus();return;}
    if(!['yes','no'].includes(attending)){toast('Pilih konfirmasi kehadiran.');attendance.focus();return;}
    let saved=parsedList(rsvpKey).filter(item=>String(item.name||'').toLocaleLowerCase('id-ID')!==name.toLocaleLowerCase('id-ID'));
    saved.unshift({name,attendance:attending,count:attending==='yes'?Math.max(1,Math.min(5,Number(rsvpCount.value)||1)):0,at:new Date().toISOString()});
    const persisted=saveStored(rsvpKey,saved.slice(0,200));updateRsvpTotal();
    toast(persisted ? 'Konfirmasi berhasil disimpan di browser ini. 🦕' : 'Konfirmasi tercatat sementara (penyimpanan browser tidak tersedia).');
    rsvpForm.reset();toggleGuestCount();
  });
  }
  // Wishes demo with safe text creation, no innerHTML from users.
  const wishList=$('#wishes-list');
  const seed=(Array.isArray(defaults.wishesSeed)?defaults.wishesSeed:[]).filter(x=>x&&typeof x==='object');
  let showAllWishes=false;
  function renderWishes(){
    if(!wishList)return;
    wishList.replaceChildren();
    const persisted=parsedList(wishesKey);
    const items=[...persisted,...seed];
    const visible=showAllWishes?items:items.slice(0,5);
    if(!items.length){const empty=document.createElement('p');empty.className='section-caption';empty.textContent='Jadilah yang pertama mengirim ucapan!';wishList.appendChild(empty);}
    visible.forEach((item,i)=>{
      const card=document.createElement('article');card.className='wish-card';
      const top=document.createElement('div');top.className='wish-card-top';const avatar=document.createElement('span');avatar.className='wish-avatar';avatar.textContent=['🦕','🌟','🌴','🎂','🥚'][i%5];
      const name=document.createElement('strong');name.textContent=clip(item.name||'Pengunjung',80);
      top.append(avatar,name);
      const p=document.createElement('p');p.textContent=clip(item.message||'',400);
      card.append(top,p);
      if(item.at){const t=document.createElement('time');try{t.textContent=new Date(item.at).toLocaleDateString('id-ID',{day:'numeric',month:'short',year:'numeric'});}catch{t.textContent='';}card.appendChild(t);}
      wishList.appendChild(card);
    });
    if(items.length>5){const btn=document.createElement('button');btn.type='button';btn.className='wishes-more';btn.textContent=showAllWishes?'TAMPILKAN LEBIH SEDIKIT':`LIHAT ${items.length-5} UCAPAN LAINNYA ↓`;btn.addEventListener('click',()=>{showAllWishes=!showAllWishes;renderWishes();});wishList.appendChild(btn);}
  }
  renderWishes();
  const wishesForm=$('#wishes-form');
  if(wishesForm&&defaults.backend?.wishes===true)wishesForm.addEventListener('submit',e=>{
    const name=clip($('#wish-name').value,80),message=clip($('#wish-message').value,255);
    if(name.length<2||message.length<3){e.preventDefault();toast('Isi nama dan ucapan terlebih dahulu.');return;}
    if(wishesForm.elements.nama)wishesForm.elements.nama.value=name;
    if(wishesForm.elements.ucapan)wishesForm.elements.ucapan.value=message;
  });
  if(wishesForm&&defaults.backend?.wishes!==true)wishesForm.addEventListener('submit',e=>{
    e.preventDefault();const name=clip($('#wish-name').value,80),message=clip($('#wish-message').value,400);
    if(name.length<2){toast('Masukkan nama minimal 2 karakter.');$('#wish-name').focus();return;}
    if(message.length<3){toast('Tulis ucapan minimal 3 karakter.');$('#wish-message').focus();return;}
    const next=[{name,message,at:new Date().toISOString()},...parsedList(wishesKey)].slice(0,100);
    const persisted=saveStored(wishesKey,next);showAllWishes=false;renderWishes();$('#wishes-form').reset();toast(persisted?'Ucapan berhasil ditambahkan di browser ini! 💌':'Ucapan tampil sementara (penyimpanan browser tidak tersedia).');
  });
  // Optional sections always fail closed if no valid content.
  const gift=defaults.gifts||{};
  if(gift.enabled && gift.serverRendered && $('#gift')){
    $('#gift').hidden=false;
    $$('[data-copy-account]','#gift').forEach(button=>button.addEventListener('click',async()=>{const ok=await copyText(button.dataset.copyAccount||'');toast(ok?'Nomor rekening berhasil disalin.':'Silakan salin nomor rekening secara manual.');}));
  }else if(gift.enabled && str(gift.bankName) && str(gift.accountNumber) && str(gift.accountHolder)){
    $('#gift').hidden=false;$('#bank-name').textContent=gift.bankName;$('#bank-number').textContent=gift.accountNumber;$('#bank-holder').textContent='a.n. '+gift.accountHolder;
    if(str(gift.deliveryAddress))$('#gift-delivery').textContent='Alamat pengiriman: '+gift.deliveryAddress;
    else $('#gift-delivery').hidden=true;
    if(str(gift.qrisImage)){const img=$('#qris-image');img.src=gift.qrisImage;img.hidden=false;img.addEventListener('error',()=>img.hidden=true);}
    $('#copy-bank-btn').addEventListener('click',async()=>{const ok=await copyText(gift.accountNumber);toast(ok?'Nomor rekening berhasil disalin.':'Silakan salin nomor rekening secara manual.');});
  }
  const extras=$('#extras');let hasExtra=false;
  const milestones=Array.isArray(defaults.milestones)?defaults.milestones:[];
  milestones.slice(0,20).forEach(item=>{if(!item||typeof item!=='object')return;hasExtra=true;const card=document.createElement('div');card.className='milestone reveal';const date=document.createElement('span');date.textContent=clip(item.emoji||'🥚',8)+' '+clip(item.year,40);const title=document.createElement('strong');title.textContent=clip(item.title,100);const detail=document.createElement('p');detail.textContent=clip(item.detail,500);card.append(date,title,detail);$('#milestones-list').appendChild(card);});
  if(defaults.birthdayVideo?.enabled && str(defaults.birthdayVideo.url)){
    const url=safeHttpUrl(defaults.birthdayVideo.url)|| (String(defaults.birthdayVideo.url).startsWith('assets/')?defaults.birthdayVideo.url:'');
    if(url){hasExtra=true;$('#birthday-video-box').hidden=false;$('#birthday-video').src=url;}
  }
  const stream=safeHttpUrl(defaults.streaming?.url);if(defaults.streaming?.enabled&&stream){hasExtra=true;$('#streaming-link').hidden=false;$('#streaming-link').href=stream;}
  const instagram=safeHttpUrl(defaults.instagramUrl);if(instagram){hasExtra=true;$('#instagram-link').hidden=false;$('#instagram-link').href=instagram;}
  extras.hidden=!hasExtra;
  // Offline calendar invitation with UTC DTSTAMP/DTSTART/DTEND.
  const icsEscape=s=>String(s||'').replace(/\\/g,'\\\\').replace(/\n/g,'\\n').replace(/,/g,'\\,').replace(/;/g,'\\;');
  const isoUtc=d=>d.toISOString().replace(/[-:]/g,'').replace(/\.\d{3}/,'');
  $('#calendar-btn').addEventListener('click',()=>{
    if(!validDate){toast('Tanggal acara belum diatur.');return;}
    const safeEnd=(!Number.isNaN(eventEnd.getTime())&&eventEnd>eventStart)?eventEnd:new Date(eventStart.getTime()+3*3600*1000);
    const now=new Date();const content=['BEGIN:VCALENDAR','VERSION:2.0','PRODID:-//Dino Jungle Birthday//Invitation//ID','CALSCALE:GREGORIAN','BEGIN:VEVENT',`UID:dino-${eventStart.getTime()}@birthday.local`,`DTSTAMP:${isoUtc(now)}`,`DTSTART:${isoUtc(eventStart)}`,`DTEND:${isoUtc(safeEnd)}`,`SUMMARY:${icsEscape('Dino Jungle Birthday - '+childName)}`,`DESCRIPTION:${icsEscape('You are invited to a roaring dinosaur birthday!')}`,`LOCATION:${icsEscape(str(defaults.venue)+' - '+str(defaults.address))}`,'END:VEVENT','END:VCALENDAR'].join('\r\n');
    const blob=new Blob([content],{type:'text/calendar;charset=utf-8'});const url=URL.createObjectURL(blob);const a=document.createElement('a');a.href=url;a.download=`dino-birthday-${firstName.toLowerCase().replace(/[^a-z0-9-]/g,'')||'invite'}.ics`;document.body.appendChild(a);a.click();a.remove();setTimeout(()=>URL.revokeObjectURL(url),1000);toast('File kalender berhasil dibuat!');
  });
  async function copyText(text){
    try{if(navigator.clipboard?.writeText){await navigator.clipboard.writeText(text);return true;}}catch{}
    const ta=document.createElement('textarea');ta.value=text;ta.style.position='fixed';ta.style.left='-9999px';document.body.appendChild(ta);ta.select();let ok=false;try{ok=document.execCommand('copy');}catch{}ta.remove();return ok;
  }
  $('#share-button').addEventListener('click',async()=>{
    const share={title:document.title,text:`Yuk datang ke Dino Jungle Birthday ${childName}! 🦕`,url:location.href};
    if(navigator.share){try{await navigator.share(share);return;}catch(err){if(err.name==='AbortError')return;}}
    const ok=await copyText(location.href);toast(ok?'Link undangan berhasil disalin.':'Salin tautan dari bilah alamat browser.');
  });
  // Music only on real user interaction, optional and isolated for shared Laravel engine.
  const audio=$('#birthday-audio'),musicButton=$('#musicToggle')||$('#music-toggle');
  if(!defaults.music?.enabled){audio?.remove();if(musicButton)musicButton.hidden=true;}
  const musicCore=window.musicPlayer;
  if(musicCore&&typeof musicCore.play==='function')audio?.remove();
  let musicPlaying=false;
  function updateMusicButton(){if(!musicButton)return;musicButton.classList.toggle('playing',musicPlaying);musicButton.setAttribute('aria-pressed',String(musicPlaying));musicButton.setAttribute('aria-label',musicPlaying?'Jeda musik':'Putar musik');$('use',musicButton)?.setAttribute('href',musicPlaying?'#i-music':'#i-music-off');}
  async function playMusic(){if(!defaults.music?.enabled)return;if(musicCore){try{await musicCore.play();musicPlaying=true;}catch{musicPlaying=false;}}else if(audio){try{audio.volume=.35;await audio.play();musicPlaying=true;}catch{musicPlaying=false;toast('Audio tidak dapat diputar. Ketuk tombol musik untuk mencoba lagi.');}}updateMusicButton();}
  if(!musicCore&&musicButton)musicButton.addEventListener('click',async()=>{if(musicPlaying){audio.pause();musicPlaying=false;updateMusicButton();}else await playMusic();});
  audio?.addEventListener('pause',()=>{musicPlaying=false;updateMusicButton();});
  audio?.addEventListener('play',()=>{musicPlaying=true;updateMusicButton();});
  // Cover opening, allows audio after tap, prevents scrolling behind cover.
  const cover=$('#cover');const openButton=$('#open-invitation');
  openButton.addEventListener('click',()=>{
    cover.classList.add('is-dismissed');cover.setAttribute('aria-hidden','true');document.body.classList.remove('is-closed');
    if(defaults.music?.enabled && defaults.music.startPlayingOnOpen)playMusic();
    const audioStart=window.matchMedia?.('(prefers-reduced-motion: reduce)').matches;
    if(!audioStart)window.scrollTo({top:0,behavior:'instant'});else window.scrollTo(0,0);
    setTimeout(()=>{$('#main-content').removeAttribute('inert');heroTitle.setAttribute('tabindex','-1');heroTitle.focus({preventScroll:true});},550);
  },{once:true});
  $('#main-content').setAttribute('inert','');
  // Reveal and navigation state, progressive enhancement when observer missing.
  function watchReveals(){const reveal=$$('.reveal');if(!('IntersectionObserver'in window)){reveal.forEach(el=>el.classList.add('is-visible'));return;}
    const obs=new IntersectionObserver(entries=>entries.forEach(e=>{if(e.isIntersecting){e.target.classList.add('is-visible');obs.unobserve(e.target);}}),{threshold:.1,rootMargin:'0px 0px 30px 0px'});reveal.forEach(el=>obs.observe(el));}
  watchReveals();
  const navLinks=$$('.nav-item');const sectionMap=navLinks.map(a=>[a,$(a.getAttribute('href'))]).filter(([,section])=>section);
  function onScroll(){const max=document.documentElement.scrollHeight-window.innerHeight;const ratio=max>0?window.scrollY/max:0;$('#reading-progress').style.width=`${Math.max(0,Math.min(100,ratio*100))}%`;
    let active=sectionMap[0]?.[0];for(const [anchor,section] of sectionMap){if(section.getBoundingClientRect().top<window.innerHeight*.48)active=anchor;}navLinks.forEach(a=>a.classList.toggle('active',a===active));}
  window.addEventListener('scroll',onScroll,{passive:true});onScroll();
  $$('.nav-item').forEach(a=>a.addEventListener('click',()=>{if(document.body.classList.contains('is-closed'))return; }));
})();
