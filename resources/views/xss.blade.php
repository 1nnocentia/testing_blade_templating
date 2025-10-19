<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Blade XSS Testing</title>
	<style>
		body { font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; padding: 2rem; }
		.box { border: 1px solid #ddd; padding: 1rem; margin-bottom: 1rem; border-radius: 6px; }
		.danger { color: #7a0b0b; }
		pre { background:#f7f7f7; padding:0.5rem; overflow:auto }
		label { display:block; margin-bottom:0.25rem }
	</style>
</head>
<body>
	<h1>Demo Blade Escaping — XSS Prevention</h1>

	<p>Halaman ini menunjukkan perbedaan antara <code>&#123;&#123; &#125;&#125;</code> (auto-escaped) dan <code>&#123;&#33;&#33; &#33;&#33;&#125;</code> (raw output) di Blade. Gunakan untuk pembelajaran — jangan pernah menampilkan <em>untrusted</em> user input dengan <code>&#123;&#33;&#33; &#33;&#33;&#125;</code> di aplikasi produksi.</p>

	<div class="box">
		<form method="get" action="/">
			<label for="input">Masukkan teks (contoh: <code>&lt;script&gt;alert('xss')&lt;/script&gt;</code>)</label>
			<input id="input" name="input" type="text" value="{{ $input ?? '' }}" style="width:100%; padding:0.5rem; margin-bottom:0.5rem">
			<button type="submit">Tampilkan</button>
		</form>
	</div>

	<div class="box">
		<h2>Contoh payload yang digunakan</h2>
		@php
			$payload = $input ?? "<script>alert('XSS')</script>";
		@endphp
		<p>Payload yang akan diuji (mentah):</p>
		<pre>{{ $payload }}</pre>
	</div>

	<div class="box">
		<h2>Output yang di-escape menggunakan <code>&#123;&#123; &#125;&#125;</code></h2>
		<p>Ketika menggunakan double curly braces Blade melakukan HTML-escaping otomatis. Contoh:</p>
		<div style="padding:0.5rem; background:#fff; border:1px solid #eee">
			{{ $payload }}
		</div>
	</div>

	<div class="box">
		<h2 class="danger">Output RAW menggunakan <code>&#123;&#33;&#33; &#33;&#33;&#125;</code> (JANGAN untuk user input)</h2>
		<p>Ini akan menampilkan konten tanpa escaping — jika payload berisi tag &lt;script&gt; maka itu dapat dieksekusi oleh browser.</p>
		<div style="padding:0.5rem; background:#fff; border:1px solid #eee">
			{!! $payload !!}
		</div>
	</div>

	<!-- Side-by-side comparison -->
	<div class="box">
		<h2>Perbandingan (Source vs Rendered)</h2>
		<p>Kolom kiri menampilkan HTML source yang dikirim ke browser (escaped). Kolom kanan menampilkan output yang dirender (raw).</p>
		<div style="display:flex; gap:1rem;">
			<div style="flex:1; border:1px solid #eee; padding:0.5rem; background:#fafafa">
				<h4>HTML source (escaped)</h4>
				<pre style="white-space:pre-wrap; word-break:break-word">{{ htmlentities($payload) }}</pre>
			</div>
			<div style="flex:1; border:1px solid #eee; padding:0.5rem; background:#fff">
				<h4>Rendered output (raw)</h4>
				<div style="padding:0.5rem; background:#fff; border:1px dashed #ddd">
					{!! $payload !!}
				</div>
			</div>
		</div>
	</div>

	<div class="box">
		<h3>Ringkasan</h3>
		<ul>
			<li><strong>&#123;&#123; &#125;&#125;</strong> — aman untuk menampilkan user input karena otomatis di-escape.</li>
			<li><strong>&#123;&#33;&#33; &#33;&#33;&#125;</strong> — menampilkan HTML mentah; berbahaya jika digunakan dengan input yang tidak tervalidasi.</li>
		</ul>
	</div>
</body>
</html>
