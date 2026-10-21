/* Princess Fairy Tale — dependency-free browser interactions. */
(() => {
  'use strict';
  const C = window.INVITATION_CONFIG;
  if (!C) { console.error('INVITATION_CONFIG tidak ditemukan.'); return; }
  const $ = (selector, root = document) => root.querySelector(selector);
  const $$ = (selector, root = document) => Array.from(root.querySelectorAll(selector));
  const get = id => document.getElementById(id);
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const formatDate = (date, options) => new Intl.DateTimeFormat('en-US', { timeZone: C.eventTimeZone || 'Asia/Jakarta', ...options }).format(date);
  const escapeICS = value => String(value || '').replaceAll('\\', '\\\\').replaceAll(/\r?\n/g, '\\n').replaceAll(',', '\\,').replaceAll(';', '\\;');
  const eventDate = new Date(C.eventDate);
  const shareUrl = () => window.location.href;
  const storageKey = 'princess-birthday-rsvp-v1:' + C.childName + ':' + C.eventDate;
  let toastTimer;
  let previousFocus = null;
  let activeModal = null;

  function toast(message) {
    const el = get('toast'); el.textContent = message; el.classList.add('is-visible');
    clearTimeout(toastTimer); toastTimer = setTimeout(() => el.classList.remove('is-visible'), 3200);
  }
  function ordinal(n) { const v = Number(n); return v + ([11,12,13].includes(v % 100) ? 'th' : ({1:'st',2:'nd',3:'rd'}[v % 10] || 'th')); }
  function safeSrc(str) { return typeof str === 'string' && !/^\s*(javascript|data):/i.test(str) ? str : ''; }
  function bindConfig() {
    $$('[data-bind]').forEach(el => { const key=el.dataset.bind; if (Object.hasOwn(C, key)) el.textContent=String(C[key]); });
    const ageString = ordinal(C.turningAge) + ' Birthday Celebration';
    $$('[data-age-title]').forEach(el => el.textContent = ageString);
    if (!Number.isNaN(eventDate.getTime())) {
      const dateLong = formatDate(eventDate, { weekday:'long',month:'long',day:'numeric',year:'numeric' });
      $$('[data-event-date-full]').forEach(el => el.textContent = dateLong);
    }
    $$('[data-child-photo]').forEach(img => { img.src = safeSrc(C.childPhoto) || 'assets/images/child-photo.webp'; img.alt = 'Foto ulang tahun ' + C.childName; });
    document.title = `${C.childName} · ${ordinal(C.turningAge)} Birthday Invitation`;
    const targetGuest = new URLSearchParams(window.location.search).get('to');
    if (targetGuest && get('invited-guest')) get('invited-guest').textContent = targetGuest.slice(0, 90).replace(/[<>]/g,'');
    const music = get('background-music');
    if (music) music.src = safeSrc(C.music?.src) || 'assets/audio/fairy-lullaby.wav';
    const mapQuery = encodeURIComponent(C.mapsQuery || `${C.venueName} ${C.address}`);
    if (get('map-link')) get('map-link').href = safeSrc(C.mapsUrl) || `https://www.google.com/maps/search/?api=1&query=${mapQuery}`;
    if (get('map-iframe')) get('map-iframe').src = `https://maps.google.com/maps?q=${mapQuery}&output=embed`;
  }
  function countdown() {
    if (Number.isNaN(eventDate.getTime())) { get('countdown-caption').textContent='Please set a valid event date in config.js'; return; }
    const difference = Math.max(0, eventDate.getTime() - Date.now());
    const days = Math.floor(difference/86400000), hours = Math.floor(difference/3600000)%24;
    const mins = Math.floor(difference/60000)%60, secs=Math.floor(difference/1000)%60;
    [['days',days],['hours',hours],['minutes',mins],['seconds',secs]].forEach(([id,value]) => { get(id).textContent = String(value).padStart(2,'0'); });
    if (difference === 0) get('countdown-caption').textContent='Today is a beautiful day to celebrate!';
  }
  function makeTimeline() {
    const target=get('timeline-list');if(!target)return;target.replaceChildren();
    (C.schedule || []).forEach((item,index) => {
      const row=document.createElement('div');row.className='timeline-item reveal';row.style.transitionDelay=`${index*90}ms`;
      const icon=document.createElement('div');icon.className='timeline-icon';icon.textContent=item.icon || '✧';
      const info=document.createElement('div');info.className='timeline-info';
      const time=document.createElement('time');time.textContent=item.time;
      const heading=document.createElement('h3');heading.textContent=item.name;
      const detail=document.createElement('p');detail.textContent=item.detail;
      info.append(time,heading,detail);row.append(icon,info);target.append(row);
    });
  }
  function makeGallery() {
    const grid=get('gallery-grid');if(!grid)return;grid.replaceChildren();
    (C.gallery || []).forEach((photo,index) => {
      const button=document.createElement('button');button.type='button';button.className='gallery-item reveal';
      button.style.transitionDelay=`${index*70}ms`;
      const image=document.createElement('img');image.src=safeSrc(photo.src);image.alt=photo.alt || photo.caption || 'Foto galeri';image.loading='lazy';
      if (/\.svg(?:[?#]|$)/i.test(photo.src || '')) button.dataset.svg='true';
      const caption=document.createElement('span');caption.className='gallery-label';caption.textContent=photo.caption || 'Sweet memory';
      button.append(image,caption);button.addEventListener('click',() => {
        get('gallery-large').src=image.src;get('gallery-large').alt=image.alt;
        get('gallery-caption').textContent=photo.caption || '';
        openModal('gallery-modal');
      });grid.append(button);
    });
  }
  function makeSparkles() {
    if (reduceMotion) return;
    const field=get('hero-sparkles');if(!field)return;
    for (let i=0;i<21;i++) {
      const p=document.createElement('span');p.className='sparkle';p.textContent=i%3===0?'✦':'✧';
      p.style.left=((i*37+9)%98)+'%';p.style.top=((i*61+12)%82)+'%';
      p.style.animationDelay=-(i*.43)+'s';p.style.fontSize=(8+(i%4)*4)+'px';field.append(p);
    }
  }
  function onScroll() {
    const h=document.documentElement.scrollHeight-window.innerHeight;
    get('scroll-progress').style.transform=`scaleX(${h>0?window.scrollY/h:0})`;
    const current=window.scrollY + window.innerHeight*.4;
    const sections=['beranda','acara','galeri','rsvp','hadiah'];
    let active='beranda';for (const id of sections) { const section=get(id); if(section&&section.offsetTop<=current)active=id; }
    $$('[data-nav]').forEach(item => { const yes=item.dataset.nav===active;item.classList.toggle('is-active',yes);if(yes)item.setAttribute('aria-current','location');else item.removeAttribute('aria-current'); });
  }
  function setupReveal() {
    const targets=$$('.reveal,.reveal-fade');
    if (!('IntersectionObserver' in window) || reduceMotion) { targets.forEach(el=>el.classList.add('is-visible'));return; }
    const io=new IntersectionObserver(entries=>entries.forEach(entry => { if(entry.isIntersecting){const el=entry.target;el.style.transitionDelay=el.style.transitionDelay || (el.dataset.revealDelay?el.dataset.revealDelay+'ms':'0ms');el.classList.add('is-visible');io.unobserve(el);} }),{threshold:.09,rootMargin:'0px 0px -30px 0px'});
    targets.forEach(el=>io.observe(el));
    // Opening text should not remain hidden while the cover is visible.
    $$('.hero-top.reveal-fade').forEach(el=>el.classList.add('is-visible'));
  }
  function openModal(id) {
    const overlay=get(id); if(!overlay)return;
    previousFocus=document.activeElement;activeModal=overlay;overlay.hidden=false;document.body.style.overflow='hidden';
    const dialog=$('[role="dialog"]',overlay); if(dialog)dialog.focus();
  }
  function closeModal() {
    if(!activeModal)return;activeModal.hidden=true;activeModal=null;
    document.body.style.overflow=get('cover-screen').classList.contains('is-leaving')?'':'hidden';
    if(previousFocus?.focus)previousFocus.focus();
  }
  function setupModals() {
    $$('[data-close-modal]').forEach(btn=>btn.addEventListener('click',closeModal));
    $$('.modal-overlay').forEach(overlay => overlay.addEventListener('click', e=> { if(e.target===overlay)closeModal(); }));
    document.addEventListener('keydown',e=>{
      if(e.key==='Escape'&&activeModal)closeModal();
      if(e.key!=='Tab'||!activeModal)return;
      const focusable=$$('button:not([disabled]),a[href],input,select,textarea',[activeModal][0]).filter(el=>el.getClientRects().length);
      if(!focusable.length)return;const first=focusable[0],last=focusable[focusable.length-1];
      if(e.shiftKey&&document.activeElement===first){e.preventDefault();last.focus();}
      else if(!e.shiftKey&&document.activeElement===last){e.preventDefault();first.focus();}
    });
    const gift=C.gift||{};
    [['giftBankName','bankName'],['giftAccountNumber','accountNumber'],['giftAccountHolder','accountHolder']].forEach(([id,key])=>$$(`[data-bind="${id}"]`).forEach(el=>el.textContent=String(gift[key]||'Belum diatur')));
    const warning = get('gift-demo-warning'); if (warning) warning.hidden=gift.demo===false;
    const giftShipping = get('gift-shipping'); if(giftShipping && gift.shippingAddress){giftShipping.hidden=false;get('gift-shipping-address').textContent=gift.shippingAddress;}
    const openGift = get('open-gift'); if (openGift) openGift.addEventListener('click',()=>openModal('gift-modal'));
    $$('[data-copy-account], #copy-account').forEach(button => button.addEventListener('click',async()=>{
      const account = button.dataset.copyAccount || gift.accountNumber;
      if(!account){toast('Nomor rekening belum diatur.');return;}
      await copyText(String(account));
    }));
  }
  function retrieveRSVP() {
    try {const parsed=JSON.parse(localStorage.getItem(storageKey)||'[]');return Array.isArray(parsed)?parsed.filter(item=>item&&typeof item.name==='string').slice(-30):[];}
    catch{return [];}
  }
  function saveRSVP(items) {
    try{localStorage.setItem(storageKey,JSON.stringify(items.slice(-30)));return true;}catch{return false;}
  }
  function renderWishes() {
    const saved=(C.backend?.rsvp ? [] : retrieveRSVP()).filter(item=>item.wish);
    const messages=[...saved.slice().reverse().map(item=>({...item,sample:false})),...(C.sampleWishes||[]).map(item=>({...item,sample:true}))];
    const list=get('wishes-list');if(!list)return;list.replaceChildren();
    if(!messages.length){const empty=document.createElement('p');empty.className='wishes-empty';empty.textContent='Be the first to leave a beautiful wish!';list.append(empty);return;}
    messages.forEach(item=>{
      const card=document.createElement('article');card.className='wish-card';
      const top=document.createElement('div');top.className='wish-card-top';
      const avatar=document.createElement('div');avatar.className='wish-avatar';avatar.textContent=String(item.name).trim().charAt(0).toUpperCase();
      const wrap=document.createElement('div');const name=document.createElement('div');name.className='wish-card-name';name.textContent=item.name;
      const status=document.createElement('div');status.className='wish-card-status';status.textContent=item.sample?'A sweet sample wish':item.attendance==='yes'?'Happily attending ♡':item.attendance==='no'?'Sending love from afar':'Still confirming';
      const text=document.createElement('p');text.textContent=item.wish||item.message||'';
      wrap.append(name,status);top.append(avatar,wrap);card.append(top,text);list.append(card);
    });
  }
  function setupRSVP() {
    const form=get('rsvp-form'),status=get('attendance'),numberField=get('guests-field');
    if(!form || !status)return;
    if(C.backend?.rsvp){
      form.addEventListener('submit',()=>{
        get('backend-name').value=get('guest-name').value.trim();
        get('backend-wish').value=get('wish-text').value.trim();
        get('backend-status').value={yes:'hadir',no:'tidak_hadir',maybe:'ragu'}[status.value] || 'ragu';
      });
      return;
    }
    status.addEventListener('change',()=> {numberField.hidden=status.value!=='yes';});
    form.addEventListener('submit',e=>{
      e.preventDefault();
      if(!form.reportValidity())return;
      const name=get('guest-name').value.trim(),attendance=status.value,wish=get('wish-text').value.trim();
      if(name.length<2||!['yes','no','maybe'].includes(attendance)){get('rsvp-note').textContent='Please enter a name and select your attendance.';get('rsvp-note').className='form-note is-error';return;}
      const item={name:name.slice(0,70),attendance,guests:attendance==='yes'?Number(get('guests').value):0,wish:wish.slice(0,500),date:new Date().toISOString()};
      const entries=retrieveRSVP();entries.push(item);
      const isSaved=saveRSVP(entries);
      get('rsvp-note').textContent=isSaved?'Thank you! Your RSVP was saved on this device.':'Please note: storage is unavailable. Your RSVP was not saved.';
      get('rsvp-note').className=isSaved?'form-note is-success':'form-note is-error';
      if(isSaved){form.reset();numberField.hidden=true;renderWishes();toast('Thank you — your wishes have been added!');}
    });
  }
  async function copyText(value) {
    try {
      if(navigator.clipboard&&window.isSecureContext){await navigator.clipboard.writeText(value);toast('Copied to clipboard!');return;}
      const input=document.createElement('textarea');input.value=value;input.style.position='fixed';input.style.opacity='0';document.body.append(input);input.select();const okay=document.execCommand('copy');input.remove();
      toast(okay?'Copied to clipboard!':'Copy unavailable on this browser.');
    }catch{toast('Unable to copy. Please select the text manually.');}
  }
  function setupMusic() {
    const audio=get('background-music'),toggle=get('music-toggle') || get('musicToggle');let playing=false;
    if(window.musicPlayer && !audio){ get('open-invitation')?.addEventListener('click',()=>window.musicPlayer.play()); return; }
    if(!audio || !toggle)return;
    if(C.music?.enabled===false){toggle.hidden=true;return;}
    const setState=value=>{playing=value;toggle.classList.toggle('is-playing',value);toggle.setAttribute('aria-pressed',String(value));toggle.title=value?'Pause music':'Play music';$('use',toggle).setAttribute('href',value?'#i-music':'#i-sound-off');};
    let appliedStart=false;
    const applyStart=()=>{
      const seconds=Number(C.music?.startSeconds)||0;
      if(!appliedStart&&seconds>0){
        try{audio.currentTime=seconds;appliedStart=true;}catch{/* Metadata not yet available; retry once loaded. */}
      }
    };
    const play=async()=>{
      try{
        if(!appliedStart&&Number(C.music?.startSeconds)>0){
          if(audio.readyState>=1)applyStart();
          else audio.addEventListener('loadedmetadata',applyStart,{once:true});
        }
        await audio.play();setState(true);
      }catch{setState(false);toast('Music could not start. Tap the music icon to try again.');}
    };
    toggle.addEventListener('click',()=>playing?audio.pause():play());
    audio.addEventListener('pause',()=>setState(false));audio.addEventListener('play',()=>setState(true));
    get('open-invitation').addEventListener('click',()=>{ if(C.music?.enabled!==false)play(); });
  }
  function setupCover() {
    const cover=get('cover-screen'),button=get('open-invitation');
    document.body.style.overflow='hidden';
    // Avoid focus in background before opening.
    get('page').setAttribute('inert','');
    button.addEventListener('click',()=>{
      cover.classList.add('is-leaving');document.body.style.overflow='';get('page').removeAttribute('inert');
      get('beranda').scrollIntoView({behavior:'instant',block:'start'});
      setTimeout(()=>{cover.hidden=true;(get('music-toggle') || get('musicToggle'))?.focus({preventScroll:true});},reduceMotion?10:980);
    },{once:true});
  }
  function makeCalendar() {
    if(Number.isNaN(eventDate.getTime())){toast('Date is not configured.');return;}
    const icsFormat = d => d.toISOString().replace(/[-:]/g,'').replace(/\.\d{3}Z$/,'Z');
    const start = eventDate;const end=new Date(start.getTime()+3*3600000);
    const content=['BEGIN:VCALENDAR','VERSION:2.0','PRODID:-//Princess Fairy Tale Birthday//ID','CALSCALE:GREGORIAN','BEGIN:VEVENT','UID:birthday-'+start.getTime()+'@invitation.example','DTSTAMP:'+icsFormat(new Date()),'DTSTART:'+icsFormat(start),'DTEND:'+icsFormat(end),'SUMMARY:'+escapeICS(ordinal(C.turningAge)+' Birthday — '+C.childName),'LOCATION:'+escapeICS(C.venueName+' · '+C.address),'DESCRIPTION:'+escapeICS('A magical birthday celebration. '+shareUrl()),'END:VEVENT','END:VCALENDAR'].join('\r\n');
    const link=document.createElement('a');link.href=URL.createObjectURL(new Blob([content],{type:'text/calendar;charset=utf-8'}));link.download='birthday-invitation.ics';document.body.append(link);link.click();link.remove();setTimeout(()=>URL.revokeObjectURL(link.href),1500);
    toast('Calendar file is ready!');
  }
  function setupShare() {
    get('calendar-btn')?.addEventListener('click',makeCalendar);
    get('share-btn')?.addEventListener('click',async()=>{
      const data={title:`${C.childName} Birthday Invitation`,text:`You're invited to ${C.childName}'s birthday!`,url:shareUrl()};
      if(navigator.share){try{await navigator.share(data);return;}catch(e){if(e.name==='AbortError')return;}}
      copyText(shareUrl());
    });
  }
  function init(){
    bindConfig();makeTimeline();makeGallery();makeSparkles();countdown();setInterval(countdown,1000);
    setupReveal();setupModals();setupRSVP();renderWishes();setupMusic();setupCover();setupShare();
    window.addEventListener('scroll',onScroll,{passive:true});onScroll();
  }
  if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',init);else init();
})();
