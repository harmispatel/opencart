// @fancyapps/ui/Carousel.Autoplay v4.0.11
class t{constructor(t){this.carousel=t,this.state="ready";for(const t of["onReady","onSettle","onMouseEnter","onMouseLeave"])this[t]=this[t].bind(this);this.events={ready:this.onReady,settle:this.onSettle}}onReady(){this.start()}onSettle(){"play"===this.state&&this.set()}onMouseEnter(){"play"===this.state&&(this.state="pause",this.clear())}onMouseLeave(){"pause"===this.state&&(this.state="play",this.set())}set(){this.clear(),this.timer=setTimeout((()=>{"play"===this.state&&this.carousel.slideTo(this.carousel.pageIndex+1)}),this.carousel.option("Autoplay.timeout"))}clear(){this.timer&&(clearTimeout(this.timer),this.timer=null)}start(){this.set(),this.state="play",this.carousel.option("Autoplay.hoverPause")&&(this.carousel.$container.addEventListener("mouseenter",this.onMouseEnter,!1),this.carousel.$container.addEventListener("mouseleave",this.onMouseLeave,!1))}stop(){this.clear(),this.state="ready",this.carousel.$container.removeEventListener("mouseenter",this.onMouseEnter,!1),this.carousel.$container.removeEventListener("mouseleave",this.onMouseLeave,!1)}attach(){this.carousel.on(this.events)}detach(){this.stop(),this.carousel.off(this.events),this.carousel=null}}var e;t.defaults={timeout:3e3,hoverPause:!0},"undefined"!=typeof Carousel&&("object"==typeof(e=Carousel.Plugins)&&null!==e&&e.constructor===Object&&"[object Object]"===Object.prototype.toString.call(e))&&(Carousel.Plugins.Autoplay=t);export{t as Autoplay};
