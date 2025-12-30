<?php
$footer_accent = isset($header_renk) ? $header_renk : '#ff7a18';
?>
<style>
    
    .cep-footer{position:fixed;left:0;right:0;bottom:0;height:70px;background:transparent;display:flex;align-items:center;justify-content:center;z-index:2999;backdrop-filter:blur(6px);border-top:1px solid rgba(255,255,255,0.04)}
    .cep-footer .inner{max-width:1100px;margin:0 auto;display:flex;gap:18px;align-items:center;justify-content:space-between;width:100%;padding:0 18px}
    .cep-footer .left{display:flex;gap:12px;align-items:center}
    .cep-footer svg{display:none}
    .cep-footer .brand-title{font-weight:800;color:#fff;font-size:1rem}
    .cep-footer .desc{opacity:0.95;line-height:1.2;color:#fff;font-size:0.95rem}
    .cep-footer .right{text-align:right;min-width:200px}
    .cep-footer a{color:#ff7a18;text-decoration:none;font-weight:700}
    .cep-footer .meta{font-size:0.95rem;color:rgba(255,235,210,0.95)}
    .cep-footer .contact{font-weight:600;color:#fff}
    @media(max-width:700px){ .cep-footer .inner{flex-direction:column;align-items:center;gap:6px} .cep-footer .right{text-align:center} }

    
    body{padding-bottom:92px}
</style>

<footer class="cep-footer" role="contentinfo">

    <div class="inner">
        <div class="left">
            <div>
                <div class="brand-title">CepKampüs</div>
                <div class="desc">Görsel kulüp & etkinlik platformu</div>
            </div>
        </div>

        <div class="right">
            <div class="contact">İletişim: <a href="mailto:emre@example.com">emre@example.com</a></div>
            <div class="meta">© <?php echo date('Y'); ?> CepKampüs — <a href="rapor.php">Rapor</a></div>
        </div>
    </div>
</footer>
