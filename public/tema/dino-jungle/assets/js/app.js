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

  // Music helper - defined early so dismissCover can trigger playback reliably
  let musicPlaying = false;
  function updateMusicButton() {
    const musicButton = $('#musicToggle') || $('#music-toggle');
    if (!musicButton) return;
    musicButton.classList.toggle('playing', musicPlaying);
    musicButton.setAttribute('aria-pressed', String(musicPlaying));
    musicButton.setAttribute('aria-label', musicPlaying ? 'Jeda musik' : 'Putar musik');
    $('use', musicButton)?.setAttribute('href', musicPlaying ? '#i-music' : '#i-music-off');
  }

  async function playMusic() {
    if (!defaults.music?.enabled) return;
    const musicCore = window.musicPlayer;
    const audio = $('#birthday-audio');
    if (musicCore && typeof musicCore.play === 'function') {
      try {
        await musicCore.play();
        musicPlaying = true;
      } catch {
        musicPlaying = false;
      }
    } else if (audio) {
      try {
        audio.volume = 0.35;
        await audio.play();
        musicPlaying = true;
      } catch {
        musicPlaying = false;
      }
    }
    updateMusicButton();
  }

  // Cover opening - registered EARLY so no other script error can block opening the invitation
  const cover = $('#cover');
  const openButton = $('#open-invitation');
  function dismissCover() {
    if (cover) {
      cover.classList.add('is-dismissed');
      cover.setAttribute('aria-hidden', 'true');
    }
    document.body.classList.remove('is-closed');
    try {
      if (defaults.music?.enabled && defaults.music.startPlayingOnOpen) {
        playMusic();
      }
    } catch (e) {
      console.warn('Audio play on open error:', e);
    }
    const prefersReducedMotion = window.matchMedia?.('(prefers-reduced-motion: reduce)').matches;
    if (!prefersReducedMotion) window.scrollTo({top: 0, behavior: 'instant'});
    else window.scrollTo(0, 0);
    setTimeout(() => {
      $('#main-content')?.removeAttribute('inert');
      const hTitle = $('#main-title');
      if (hTitle) {
        hTitle.setAttribute('tabindex', '-1');
        hTitle.focus({preventScroll: true});
      }
    }, 550);
  }
  window.dinoDismissCover = dismissCover;
  if (openButton) {
    openButton.addEventListener('click', dismissCover, {once: true});
  }

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
  if (mapsLink) {
    if (mapsUrl) mapsLink.href = mapsUrl;
    else mapsLink.hidden = true;
  }

  const heroTitle = $('#main-title');
  document.title = `Dino Jungle Birthday — ${childName} Turns ${childAge}`;
  const toastElement = $('#toast');
  let toastTimer = null;
  function toast(message) {
    if (!toastElement) return;
    toastElement.textContent = message;
    toastElement.classList.add('show');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => toastElement.classList.remove('show'), 3200);
  }
  function readLocal(key) { try { return JSON.parse(localStorage.getItem(key) || 'null'); } catch { return null; } }
  const fallbackStore = {};
  function getStored(key) { return readLocal(key) ?? fallbackStore[key] ?? []; }
  function saveStored(key, data) { fallbackStore[key] = data; try { localStorage.setItem(key, JSON.stringify(data)); return true; } catch { return false; } }

  const storageScope = `dino-v1:${childName.toLowerCase()}:${defaults.dateTimeISO || 'no-date'}`;
  const rsvpKey = `${storageScope}:rsvp`, wishesKey = `${storageScope}:wishes`;
  const parsedList = key => { const val = getStored(key); return Array.isArray(val) ? val : []; };

  if (str(defaults.childPhoto)) {
    const src = str(defaults.childPhoto);
    const allowed = safeHttpUrl(src) || (src.startsWith('assets/') ? src : '');
    if (allowed) {
      const frame = $('#child-photo-wrap'), photo = $('#child-photo');
      if (frame && photo) {
        frame.hidden = false;
        photo.src = allowed;
        photo.alt = 'Foto ' + childName;
        photo.addEventListener('error', () => { frame.hidden = true; });
      }
    }
  }
  if (heroTitle) {
    if (firstName.length > 10) heroTitle.classList.add('very-long-name');
    else if (firstName.length > 7) heroTitle.classList.add('long-name');
  }

  function updateCountdown() {
    const total = validDate ? Math.max(0, eventStart.getTime() - Date.now()) : 0;
    const seconds = Math.floor(total / 1000);
    const parts = [Math.floor(seconds / 86400),Math.floor(seconds % 86400 / 3600),Math.floor(seconds % 3600 / 60),seconds % 60];
    ['cd-days','cd-hours','cd-minutes','cd-seconds'].forEach((id, i) => { const node = document.getElementById(id); if (node) node.textContent = String(parts[i]).padStart(2,'0'); });
    const cdCaption = $('#countdown-caption');
    if (cdCaption) {
      cdCaption.textContent = !validDate ? 'Tanggal acara akan segera diumumkan.' : total === 0 ? 'Hooray! Hari petualangan dinosaurus telah tiba atau berlalu! 🦕' : 'Siapkan sepatu petualangmu. Pestanya segera dimulai!';
    }
  }
  updateCountdown();
  setInterval(updateCountdown, 1000);

  // Schedule cards: safe handling if container is missing or server-rendered
  const agendaList = $('#agenda-list');
  const agenda = Array.isArray(defaults.agenda) ? defaults.agenda : [];
  if (agendaList && agendaList.children.length === 0) {
    if (!agenda.length) {
      const p = document.createElement('p');p.className='section-caption';p.textContent='Rangkaian acara akan segera diumumkan.';agendaList.appendChild(p);
    }
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
  }

  // Images and lightbox
  const galleryGrid = $('#gallery-grid');
  const gallery = (Array.isArray(defaults.gallery) ? defaults.gallery : []).filter(x => x && typeof x === 'object' && str(x.src)).slice(0,30);
  if (galleryGrid && galleryGrid.children.length === 0) {
    if (!gallery.length) {
      const empty = document.createElement('div');empty.className='gallery-empty reveal';empty.textContent='Foto-foto petualangan akan segera hadir. 🌿';galleryGrid.appendChild(empty);
    }
    gallery.forEach((item,index)=>{
      const b=document.createElement('button');b.type='button';b.className='gallery-item reveal';b.setAttribute('aria-label','Lihat foto: '+clip(item.caption||`Galeri ${index+1}`,90));
      const img=document.createElement('img');img.src=str(item.src);img.alt=clip(item.caption||`Foto galeri ${index+1}`,120);img.loading='lazy';
      img.addEventListener('error',()=>{if(img.src!==fallbackImage)img.src=fallbackImage;});
      const cap=document.createElement('span');cap.textContent=clip(item.caption||`Galeri ${index+1}`,80);
      b.append(img,cap);b.addEventListener('click',()=>showLightbox(img.currentSrc||img.src,cap.textContent,b));galleryGrid.appendChild(b);
    });
  }
  const lightbox = $('#lightbox');
  let previousFocus = null;
  function closeLightbox() {
    if (lightbox) lightbox.hidden=true;
    document.body.style.overflow='';
    if (previousFocus && typeof previousFocus.focus === 'function') previousFocus.focus();
  }
  function showLightbox(src,caption,button) {
    previousFocus=button;
    const lImg = $('#lightbox-image');
    if (lImg) { lImg.src=src; lImg.alt=caption; }
    const lCap = $('#lightbox-caption');
    if (lCap) lCap.textContent=caption;
    if (lightbox) lightbox.hidden=false;
    document.body.style.overflow='hidden';
    $('#lightbox-close')?.focus();
  }
  $('#lightbox-close')?.addEventListener('click',closeLightbox);
  lightbox?.addEventListener('click',e=>{if(e.target===lightbox)closeLightbox();});
  document.addEventListener('keydown',e=>{ if(e.key==='Escape'&&lightbox&&!lightbox.hidden)closeLightbox(); if(e.key==='Tab'&&lightbox&&!lightbox.hidden){e.preventDefault();$('#lightbox-close')?.focus();}});

  // RSVP
  const rsvpForm=$('#rsvp-form');
  const attendance=$('#rsvp-attendance');
  const countWrap=$('#rsvp-guest-count-wrap');
  const rsvpCount=$('#rsvp-count');
  if(rsvpForm&&attendance&&countWrap&&rsvpCount){
    const rsvpName=$('#rsvp-name');
    if (rsvpName) rsvpName.value=guestName===str(defaults.guestFallbackName,'Teman Spesial') ? '' : guestName;
    const wishNameInput=$('#wish-name');
    if(wishNameInput&&rsvpName)wishNameInput.value=rsvpName.value;
    function toggleGuestCount(){ countWrap.hidden=attendance.value!=='yes';rsvpCount.disabled=attendance.value!=='yes'; }
    attendance.addEventListener('change',toggleGuestCount);toggleGuestCount();
    function updateRsvpTotal(){
      const total=parsedList(rsvpKey).reduce((acc,item)=>acc+(item?.attendance==='yes' ? Math.max(1,Math.min(5,Number(item.count)||1)):0),0);
      const rsvpTotalEl = $('#rsvp-total');
      if (rsvpTotalEl) rsvpTotalEl.textContent=String(total);
    }
    updateRsvpTotal();
    if(defaults.backend?.rsvp===true){
      rsvpForm.addEventListener('submit',e=>{
        const name=clip(rsvpName?.value,80);const attending=attendance.value;
        if(name.length<2){e.preventDefault();toast('Masukkan nama minimal 2 karakter.');rsvpName?.focus();return;}
        if(!['yes','no'].includes(attending)){e.preventDefault();toast('Pilih konfirmasi kehadiran.');attendance.focus();return;}
        if(rsvpForm.elements.nama)rsvpForm.elements.nama.value=name;
        if(rsvpForm.elements.status)rsvpForm.elements.status.value=attending==='yes'?'hadir':'tidak_hadir';
        if(rsvpForm.elements.ucapan&&!rsvpForm.elements.ucapan.value.trim())rsvpForm.elements.ucapan.value='Konfirmasi kehadiran di pesta ulang tahun.';
      });
    }else{
      rsvpForm.addEventListener('submit',e=>{
        e.preventDefault();
        const name=clip(rsvpName?.value,80);const attending=attendance.value;
        if(name.length<2){toast('Masukkan nama minimal 2 karakter.');rsvpName?.focus();return;}
        if(!['yes','no'].includes(attending)){toast('Pilih konfirmasi kehadiran.');attendance.focus();return;}
        let saved=parsedList(rsvpKey).filter(item=>String(item.name||'').toLocaleLowerCase('id-ID')!==name.toLocaleLowerCase('id-ID'));
        saved.unshift({name,attendance:attending,count:attending==='yes'?Math.max(1,Math.min(5,Number(rsvpCount.value)||1)):0,at:new Date().toISOString()});
        const persisted=saveStored(rsvpKey,saved.slice(0,200));updateRsvpTotal();
        toast(persisted ? 'Konfirmasi berhasil disimpan di browser ini. 🦕' : 'Konfirmasi tercatat sementara (penyimpanan browser tidak tersedia).');
        rsvpForm.reset();toggleGuestCount();
      });
    }
  }

  // Wishes
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
  if(wishesForm&&defaults.backend?.wishes===true){
    wishesForm.addEventListener('submit',e=>{
      const name=clip($('#wish-name')?.value,80),message=clip($('#wish-message')?.value,255);
      if(name.length<2||message.length<3){e.preventDefault();toast('Isi nama dan ucapan terlebih dahulu.');return;}
      if(wishesForm.elements.nama)wishesForm.elements.nama.value=name;
      if(wishesForm.elements.ucapan)wishesForm.elements.ucapan.value=message;
    });
  } else if(wishesForm){
    wishesForm.addEventListener('submit',e=>{
      e.preventDefault();const name=clip($('#wish-name')?.value,80),message=clip($('#wish-message')?.value,400);
      if(name.length<2){toast('Masukkan nama minimal 2 karakter.');$('#wish-name')?.focus();return;}
      if(message.length<3){toast('Tulis ucapan minimal 3 karakter.');$('#wish-message')?.focus();return;}
      const next=[{name,message,at:new Date().toISOString()},...parsedList(wishesKey)].slice(0,100);
      const persisted=saveStored(wishesKey,next);showAllWishes=false;renderWishes();$('#wishes-form').reset();toast(persisted?'Ucapan berhasil ditambahkan di browser ini! 💌':'Ucapan tampil sementara (penyimpanan browser tidak tersedia).');
    });
  }

  // Gifts
  const gift=defaults.gifts||{};
  if(gift.enabled && gift.serverRendered && $('#gift')){
    $('#gift').hidden=false;
    $$('[data-copy-account]','#gift').forEach(button=>button.addEventListener('click',async()=>{const ok=await copyText(button.dataset.copyAccount||'');toast(ok?'Nomor rekening berhasil disalin.':'Silakan salin nomor rekening secara manual.');}));
  }else if(gift.enabled && str(gift.bankName) && str(gift.accountNumber) && str(gift.accountHolder)){
    const gEl = $('#gift');
    if (gEl) {
      gEl.hidden=false;
      const bn = $('#bank-name'); if (bn) bn.textContent=gift.bankName;
      const bnum = $('#bank-number'); if (bnum) bnum.textContent=gift.accountNumber;
      const bh = $('#bank-holder'); if (bh) bh.textContent='a.n. '+gift.accountHolder;
      const gd = $('#gift-delivery');
      if (gd) {
        if(str(gift.deliveryAddress)) gd.textContent='Alamat pengiriman: '+gift.deliveryAddress;
        else gd.hidden=true;
      }
      if(str(gift.qrisImage)){const img=$('#qris-image');if(img){img.src=gift.qrisImage;img.hidden=false;img.addEventListener('error',()=>img.hidden=true);}}
      $('#copy-bank-btn')?.addEventListener('click',async()=>{const ok=await copyText(gift.accountNumber);toast(ok?'Nomor rekening berhasil disalin.':'Silakan salin nomor rekening secara manual.');});
    }
  }

  // Extras
  const extras=$('#extras');let hasExtra=false;
  const milestones=Array.isArray(defaults.milestones)?defaults.milestones:[];
  const milestonesList = $('#milestones-list');
  if (milestonesList) {
    milestones.slice(0,20).forEach(item=>{
      if(!item||typeof item!=='object')return;
      hasExtra=true;
      const card=document.createElement('div');card.className='milestone reveal';
      const date=document.createElement('span');date.textContent=clip(item.emoji||'🥚',8)+' '+clip(item.year,40);
      const title=document.createElement('strong');title.textContent=clip(item.title,100);
      const detail=document.createElement('p');detail.textContent=clip(item.detail,500);
      card.append(date,title,detail);
      milestonesList.appendChild(card);
    });
  }
  if(defaults.birthdayVideo?.enabled && str(defaults.birthdayVideo.url)){
    const url=safeHttpUrl(defaults.birthdayVideo.url)|| (String(defaults.birthdayVideo.url).startsWith('assets/')?defaults.birthdayVideo.url:'');
    if(url){hasExtra=true;const vb=$('#birthday-video-box');if(vb)vb.hidden=false;const v=$('#birthday-video');if(v)v.src=url;}
  }
  const stream=safeHttpUrl(defaults.streaming?.url);if(defaults.streaming?.enabled&&stream){hasExtra=true;const sl=$('#streaming-link');if(sl){sl.hidden=false;sl.href=stream;}}
  const instagram=safeHttpUrl(defaults.instagramUrl);if(instagram){hasExtra=true;const il=$('#instagram-link');if(il){il.hidden=false;il.href=instagram;}}
  if (extras) extras.hidden=!hasExtra;

  const icsEscape=s=>String(s||'').replace(/\\/g,'\\\\').replace(/\n/g,'\\n').replace(/,/g,'\\,').replace(/;/g,'\\;');
  const isoUtc=d=>d.toISOString().replace(/[-:]/g,'').replace(/\.\d{3}/,'');
  $('#calendar-btn')?.addEventListener('click',()=>{
    if(!validDate){toast('Tanggal acara belum diatur.');return;}
    const safeEnd=(!Number.isNaN(eventEnd.getTime())&&eventEnd>eventStart)?eventEnd:new Date(eventStart.getTime()+3*3600*1000);
    const now=new Date();const content=['BEGIN:VCALENDAR','VERSION:2.0','PRODID:-//Dino Jungle Birthday//Invitation//ID','CALSCALE:GREGORIAN','BEGIN:VEVENT',`UID:dino-${eventStart.getTime()}@birthday.local`,`DTSTAMP:${isoUtc(now)}`,`DTSTART:${isoUtc(eventStart)}`,`DTEND:${isoUtc(safeEnd)}`,`SUMMARY:${icsEscape('Dino Jungle Birthday - '+childName)}`,`DESCRIPTION:${icsEscape('You are invited to a roaring dinosaur birthday!')}`,`LOCATION:${icsEscape(str(defaults.venue)+' - '+str(defaults.address))}`,'END:VEVENT','END:VCALENDAR'].join('\r\n');
    const blob=new Blob([content],{type:'text/calendar;charset=utf-8'});const url=URL.createObjectURL(blob);const a=document.createElement('a');a.href=url;a.download=`dino-birthday-${firstName.toLowerCase().replace(/[^a-z0-9-]/g,'')||'invite'}.ics`;document.body.appendChild(a);a.click();a.remove();setTimeout(()=>URL.revokeObjectURL(url),1000);toast('File kalender berhasil dibuat!');
  });

  async function copyText(text){
    try{if(navigator.clipboard?.writeText){await navigator.clipboard.writeText(text);return true;}}catch{}
    const ta=document.createElement('textarea');ta.value=text;ta.style.position='fixed';ta.style.left='-9999px';document.body.appendChild(ta);ta.select();let ok=false;try{ok=document.execCommand('copy');}catch{}ta.remove();return ok;
  }
  $('#share-button')?.addEventListener('click',async()=>{
    const share={title:document.title,text:`Yuk datang ke Dino Jungle Birthday ${childName}! 🦕`,url:location.href};
    if(navigator.share){try{await navigator.share(share);return;}catch(err){if(err.name==='AbortError')return;}}
    const ok=await copyText(location.href);toast(ok?'Link undangan berhasil disalin.':'Salin tautan dari bilah alamat browser.');
  });

  // Music controls
  const audio=$('#birthday-audio'),musicButton=$('#musicToggle')||$('#music-toggle');
  if(!defaults.music?.enabled){audio?.remove();if(musicButton)musicButton.hidden=true;}
  const musicCore=window.musicPlayer;
  if(musicCore&&typeof musicCore.play==='function')audio?.remove();
  if(!musicCore&&musicButton)musicButton.addEventListener('click',async()=>{if(musicPlaying){audio?.pause();musicPlaying=false;updateMusicButton();}else await playMusic();});
  audio?.addEventListener('pause',()=>{musicPlaying=false;updateMusicButton();});
  audio?.addEventListener('play',()=>{musicPlaying=true;updateMusicButton();});

  $('#main-content')?.setAttribute('inert','');

  // Reveal & scroll
  function watchReveals(){
    const reveal=$$('.reveal');
    if(!('IntersectionObserver'in window)){reveal.forEach(el=>el.classList.add('is-visible'));return;}
    const obs=new IntersectionObserver(entries=>entries.forEach(e=>{if(e.isIntersecting){e.target.classList.add('is-visible');obs.unobserve(e.target);}}),{threshold:.1,rootMargin:'0px 0px 30px 0px'});
    reveal.forEach(el=>obs.observe(el));
  }
  watchReveals();

  const navLinks=$$('.nav-item');
  const sectionMap=navLinks.map(a=>[a,$(a.getAttribute('href'))]).filter(([,section])=>section);
  function onScroll(){
    const max=document.documentElement.scrollHeight-window.innerHeight;
    const ratio=max>0?window.scrollY/max:0;
    const rp = $('#reading-progress');
    if (rp) rp.style.width=`${Math.max(0,Math.min(100,ratio*100))}%`;
    let active=sectionMap[0]?.[0];
    for(const [anchor,section] of sectionMap){
      if(section.getBoundingClientRect().top<window.innerHeight*.48)active=anchor;
    }
    navLinks.forEach(a=>a.classList.toggle('active',a===active));
  }
  window.addEventListener('scroll',onScroll,{passive:true});
  onScroll();
  $$('.nav-item').forEach(a=>a.addEventListener('click',()=>{if(document.body.classList.contains('is-closed'))return; }));
})();
