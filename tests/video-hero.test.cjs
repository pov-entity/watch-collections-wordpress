const {test}=require('node:test');
const assert=require('node:assert/strict');
const vm=require('node:vm');
const fs=require('node:fs');
const code=fs.readFileSync(require('node:path').join(__dirname,'../assets/js/week-hero.js'),'utf8');
function setup({rejectPlay=false,reduced=false}={}) {
  function node(attrs={}) {const listeners={};const classes=new Set();return {attrs,textContent:'',classList:{add:c=>classes.add(c),remove:c=>classes.delete(c),contains:c=>classes.has(c),toggle(c,b){if(b===undefined)b=!classes.has(c);b?classes.add(c):classes.delete(c);}},getAttribute:k=>attrs[k]??null,setAttribute:(k,v)=>attrs[k]=v,addEventListener:(k,f)=>(listeners[k]??=[]).push(f),emit(k,e={}){for(const f of listeners[k]||[])f(e);},focus(){}};}
  const labels=['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
  const tabs=labels.map(d=>node({'data-day':d,'data-style':d+' style','data-moment':d+' occasion'}));
  const images=labels.map(()=>node());const motion=node();const day=node();const hero=node();
  const video=node({'data-video-available':'1'});video.duration=10.005;video.readyState=4;video.paused=true;video.seeking=false;video.time=0;video.playCalls=0;
  Object.defineProperty(video,'currentTime',{get:()=>video.time,set:t=>{video.time=t;video.seeking=true;}});
  video.pause=()=>{video.paused=true;video.emit('pause');};
  video.play=()=>{video.playCalls++;if(rejectPlay)return Promise.reject(new Error('NotAllowedError'));video.paused=false;video.emit('play');video.emit('playing');return Promise.resolve();};
  const map={'[data-hero-video]':video,'[data-hero-motion]':motion,'[data-hero-motion-label]':node(),'[data-hero-count]':node(),'[data-hero-day]':day,'[data-hero-moment]':node(),'[data-hero-style]':node(),'[data-hero-status]':node(),'[data-hero-announcer]':node()};
  hero.querySelector=s=>map[s];hero.querySelectorAll=s=>s==='[data-hero-tab]'?tabs:images;
  const document=node();document.hidden=false;document.querySelector=s=>s==='[data-week-hero]'?hero:null;
  const raf=[];const preference={matches:reduced,addEventListener(){}};
  const window={matchMedia:()=>preference,requestAnimationFrame:f=>{raf.push(f);return raf.length;}};
  vm.runInNewContext(code,{document,window,Number,Boolean,Array,String});
  return {video,hero,day,motion,tabs,frame(){const f=raf.shift();if(f)f();},seeked(){video.seeking=false;video.emit('seeked');},setPlayFailure(v){rejectPlay=v;}};
}
test('attempts muted inline autoplay immediately',()=>{const s=setup();assert.equal(s.video.playCalls,1);assert.equal(s.video.muted,true);assert.equal(s.video.defaultMuted,true);assert.equal(s.video.playsInline,true);assert.equal(s.video.controls,false);});
test('autoplay denial retains the matching preview without exposing native video',async()=>{const s=setup({rejectPlay:true});await Promise.resolve();assert.equal(s.hero.classList.contains('is-autoplay-blocked'),true);assert.equal(s.hero.classList.contains('has-started'),false);assert.equal(s.day.textContent,'Monday');assert.equal(s.motion.attrs['aria-label'],'Play the weekly video');});
test('day selection masks seeking, matches the watch immediately and holds its exact pose',()=>{const s=setup();s.tabs[4].emit('click');assert.equal(s.day.textContent,'Friday');assert.ok(Math.abs(s.video.currentTime-6.425)<.001);assert.equal(s.hero.classList.contains('is-switching'),true);s.seeked();s.frame();s.frame();assert.equal(s.hero.classList.contains('is-switching'),false);s.video.time=6.63;s.frame();assert.equal(s.video.paused,true);assert.equal(s.video.currentTime,6.625);assert.equal(s.day.textContent,'Friday');});
test('rapid day changes keep the latest selection and freeze frame',()=>{const s=setup();s.tabs[1].emit('click');s.tabs[6].emit('click');s.seeked();s.frame();s.frame();s.video.time=9.13;s.frame();assert.equal(s.day.textContent,'Sunday');assert.equal(s.video.currentTime,9.125);assert.equal(s.video.paused,true);});
test('reduced motion skips autoplay and holds the requested matching frame',()=>{const s=setup({reduced:true});assert.equal(s.video.playCalls,0);s.tabs[2].emit('click');assert.equal(s.video.currentTime,3.75);assert.equal(s.day.textContent,'Wednesday');assert.equal(s.video.paused,true);s.motion.emit('click');assert.equal(s.video.playCalls,1);});
