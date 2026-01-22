<div class="col-lg-3 col-6">
  <!-- small box -->
  <div class="small-box {{ $type }} shadow glossy">
    <div class="inner">
      <h4 class="text-bold">{{ $value }}</h4>
      <p>{{ $label }}</p>
    </div>
    <div class="icon">
      <i class="{{ $icon }}"></i>
    </div>
  </div>
</div>

<style>
/* Glossy effect for dashboard cards - neutral colors */
.small-box.glossy {
  position: relative;
  overflow: hidden;
  border-radius: 12px;
  background: linear-gradient(145deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05)) 
              /* fallback for your $type background */
              , inherit;
  color: white; /* text stays white */
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.small-box.glossy::before {
  content: '';
  position: absolute;
  top: -50%;
  left: -50%;
  width: 200%;
  height: 200%;
  background: radial-gradient(circle at 50% 50%, rgba(255,255,255,0.25) 0%, transparent 60%);
  transform: rotate(25deg);
  pointer-events: none;
}

.small-box.glossy:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 30px rgba(0,0,0,0.2);
}

/* Icon stays white */
.small-box.glossy .icon i {
  color: white !important;
  font-size: 50px;
  opacity: 0.9;
}

/* Keep text on top of glossy effect */
.small-box.glossy .inner h4,
.small-box.glossy .inner p {
  z-index: 1;
  position: relative;
}
</style>
