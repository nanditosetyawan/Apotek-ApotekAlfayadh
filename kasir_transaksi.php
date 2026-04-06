<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['jabatan'] != 'kasir') {
    header("Location: index.php");
    exit;
}

include "koneksi.php";

$obat = mysqli_query($conn, "SELECT * FROM obat ORDER BY nama ASC");
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Transaksi</title>
<link rel="stylesheet" href="css/kasir_transaksi_ui.css">
</head>

<body>

<div class="container">

<!-- TOP -->
<div class="top-bar">
    <button class="search-btn" onclick="openSearch()">🔍</button>

    <div class="top-text">
        <div id="dayDate" class="bg"></div>
        <div id="clock" class="bg"></div>
    </div>
</div>

<!-- BOX -->
<div class="img-box">
    <div class="carousel-track" id="carouselTrack">
        <div class="slide" style="background-image:url('img/banner1.png')"></div>
        <div class="slide" style="background-image:url('img/banner2.png')"></div>
    </div>

    <!-- DOT -->
    <div class="dots">
        <span class="dot active"></span>
        <span class="dot"></span>
    </div>
</div>

<!-- INPUT -->
<div class="input-row">
    <input type="text" id="inputManual" onkeyup="handleInput()" placeholder="Input obat">
    <button onclick="tambahManual()" class="btn-small">OK</button>
</div>

<div id="suggestionBox" class="suggest-box"></div>

<!-- CART -->
<div class="cart-box" id="cartBox"></div>

<!-- METODE -->
<div class="metode-box" onclick="openMetode()">
    <span>METODE BAYAR</span>
    <div class="metode-btn" id="metodeTerpilih">ADD</div>
</div>
<br>
<!-- TOTAL -->
<div class="total-box">
    <span>TOTAL:</span>
    <strong id="totalHarga">Rp 0</strong>
</div>

<!-- ACTION -->
<div class="action-box">
    <button class="btn-reset" onclick="resetCart()">⟳</button>
    <button class="btn-bayar" onclick="bayar()">BAYAR</button>
</div>

</div>

<!-- OVERLAY SEARCH -->
<div id="overlaySearch" class="overlay">
<div class="overlay-content">

    <div class="search-bar">
        <input type="text" id="searchInput" onkeyup="filterObat()" placeholder="search...">
        🔍
    </div>

    <div class="list-obat">

    <?php while($o = mysqli_fetch_assoc($obat)): ?>
    <div class="obat-item"
        data-id="<?= $o['id_obat']; ?>"
        data-nama="<?= strtolower($o['nama']); ?>"
        data-harga="<?= $o['harga']; ?>">

        <img src="<?= !empty($o['gambar']) ? $o['gambar'] : 'img/obat/default.png' ?>" class="img">

        <div class="info">
            <div class="nama"><?= $o['nama']; ?></div>
            <div>Rp <?= number_format($o['harga'],0,',','.'); ?></div>
            <small>sisa: <?= $o['stok']; ?> pcs</small>
        </div>

        <div class="qty">
            <button onclick="kurang(this)">-</button>
            <span class="jumlah">0</span>
            <button onclick="tambah(this)">+</button>
        </div>
    </div>
    <?php endwhile; ?>

    </div>

    <button class="btn-add" onclick="addToCart()">ADD</button>

</div>
</div>

<!-- OVERLAY METODE -->
<div id="overlayMetode" class="overlay">
<div class="overlay-content small">

    <div class="radio-item">
        <label>GOPAY</label>
        <input type="radio" name="metode" value="GOPAY">
    </div>

    <div class="radio-item">
        <label>QRIS</label>
        <input type="radio" name="metode" value="QRIS">
    </div>

    <div class="radio-item">
        <label>CASH</label>
        <input type="radio" name="metode" value="CASH">
    </div>

    <button class="btn-add" onclick="pilihMetode()">ADD</button>

</div>
</div>


<!-- ===== OVERLAY SUKSES ===== -->
<div id="overlaySukses" class="overlay">

    <div class="overlay-content small" style="text-align:center">

        <h3>Pembayaran diterima</h3>

        <br>

        <button onclick="lanjut()" class="btn-add">
            LANJUT
        </button>

    </div>

</div>


<script>

/* JAM */
function updateTime(){
    const now = new Date();
    document.getElementById("dayDate").innerText =
        now.toLocaleDateString('id-ID',{weekday:'long',day:'numeric',month:'long',year:'numeric'});
    document.getElementById("clock").innerText =
        now.toLocaleTimeString();
}
setInterval(updateTime,1000);
updateTime();

/* OVERLAY */
function openSearch(){ document.getElementById("overlaySearch").style.display="flex"; }
function openMetode(){ document.getElementById("overlayMetode").style.display="flex"; }

window.onclick = function(e){
    if(e.target.classList.contains("overlay")){
        e.target.style.display="none";
    }
}

/* SEARCH */
function filterObat(){
    const val = document.getElementById("searchInput").value.toLowerCase();
    document.querySelectorAll(".obat-item").forEach(item=>{
        item.style.display = item.dataset.nama.includes(val) ? "flex":"none";
    });
}

/* QTY */
function tambah(btn){
    let span = btn.parentElement.querySelector(".jumlah");
    span.innerText = parseInt(span.innerText) + 1;
}
function kurang(btn){
    let span = btn.parentElement.querySelector(".jumlah");
    let val = parseInt(span.innerText);
    if(val>0) span.innerText = val-1;
}

/* CART */
let cart = {};

function addToCart(){
    document.querySelectorAll(".obat-item").forEach(item=>{
        let qty = parseInt(item.querySelector(".jumlah").innerText);
        if(qty>0){
            let id = item.dataset.id;
            let nama = item.querySelector(".nama").innerText;
            let harga = parseInt(item.dataset.harga);

            if(cart[id]){
                cart[id].jumlah += qty;
            }else{
                cart[id] = {nama,harga,jumlah:qty};
            }
        }
        item.querySelector(".jumlah").innerText=0;
    });

    renderCart();
    document.getElementById("overlaySearch").style.display="none";
}

function renderCart(){
    let html="";
    let total=0;

    Object.values(cart).forEach(c=>{
        total += c.harga*c.jumlah;
        html+=`<div class="cart-item">
            <span>${c.nama}</span>
            <span>x ${c.jumlah}</span>
            <strong>Rp ${c.harga.toLocaleString("id-ID")}</strong>
        </div>`;
    });

    document.getElementById("cartBox").innerHTML=html;
    document.getElementById("totalHarga").innerText="Rp "+total.toLocaleString("id-ID");
}

function resetCart(){
    cart={};
    renderCart();
    document.getElementById("metodeTerpilih").innerText="ADD";
    document.querySelectorAll('input[name="metode"]').forEach(r=>r.checked=false);
}

/* AUTOCOMPLETE (DEBOUNCE FIX) */
let obatList = [];
let debounceTimer;

window.onload = function(){
    document.querySelectorAll(".obat-item").forEach(el=>{
        obatList.push({
            id: el.dataset.id,
            nama: el.dataset.nama,
            harga: parseInt(el.dataset.harga)
        });
    });
}

function handleInput(){
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(()=>{ autocomplete(); }, 500);
}

function autocomplete(){
    let val = document.getElementById("inputManual").value.toLowerCase();
    let box = document.getElementById("suggestionBox");

    box.innerHTML = "";

    if(val.length < 2){
        box.style.display="none";
        return;
    }

    let found=false;

    obatList.forEach(o=>{
        if(o.nama.includes(val)){
            found=true;
            box.innerHTML += `<div class="suggest-item"
                onclick="pilihObat('${o.id}','${o.nama}',${o.harga})">
                ${o.nama}</div>`;
        }
    });

    box.style.display="block";

    if(!found){
        box.innerHTML=`<div class="suggest-item">Tidak ditemukan</div>`;
    }
}

function pilihObat(id,nama,harga){
    let input=document.getElementById("inputManual");
    input.value=nama;
    input.dataset.id=id;
    input.dataset.harga=harga;
    document.getElementById("suggestionBox").innerHTML="";
}

function tambahManual(){
    let input=document.getElementById("inputManual");
    let id=input.dataset.id;

    if(!id) return alert("Pilih dari saran");

    if(cart[id]){
        cart[id].jumlah+=1;
    }else{
        cart[id]={nama:input.value,harga:parseInt(input.dataset.harga),jumlah:1};
    }

    renderCart();
    input.value="";
}

/* METODE */
function pilihMetode(){
    let m=document.querySelector('input[name="metode"]:checked');
    if(m){
        document.getElementById("metodeTerpilih").innerText=m.value;
        document.getElementById("overlayMetode").style.display="none";
    }
}

/* BAYAR */
function bayar(){
    if(Object.keys(cart).length===0) return alert("Kosong");

    fetch("proses_bayar.php",{
        method:"POST",
        headers:{"Content-Type":"application/json"},
        body:JSON.stringify(cart)
    })
    .then(res => res.text())
    .then(()=>{
        // tampilkan overlay sukses
        document.getElementById("overlaySukses").style.display = "flex";
    });
}

function lanjut(){
    window.location.href = "kasir_transaksi.php";
}

/* ===== CAROUSEL FIX FINAL ===== */
window.addEventListener("load", function(){

    let index = 0;

    const track = document.getElementById("carouselTrack");
    const slides = document.querySelectorAll(".slide");
    const dots = document.querySelectorAll(".dot");

    if(!track || slides.length === 0) return;

    const total = slides.length;

    setInterval(()=>{

        index = (index + 1) % total;

        track.style.transform = `translateX(-${index * 100}%)`;

        // update dot
        dots.forEach(d => d.classList.remove("active"));
        if(dots[index]) dots[index].classList.add("active");

    }, 2500);

});
</script>

</body>
</html>