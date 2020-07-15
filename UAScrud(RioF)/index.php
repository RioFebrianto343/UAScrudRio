<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Welcome</title>
    <link rel="stylesheet" href="style1.css" />
  </head>
  <body>

    <div class="nav-container">
      <div class="wrapper">
        <nav>
          <div class="logo">
            Portfolio
          </div>
        
          <ul class="nav-items">
            <li>
              <a href="index.php">Crud</a>
            </li>
            <li>
              <a href="about.html">Biodata</a>
            </li>

            <li>
              <a href="index.html">Portofolio</a>
            </li>

            <li>
              <a href="contact.html">Contact</a>
            </li>

            <li>
              <a href="keahlian.html">Keahlian</a>
            </li>

          </ul>
        </nav>
      </div>
    </div>
<br>
<div class="header-container">
<div class="wrapper">
<?php

$q="";
if (isset($_GET['submit']) && !empty($_GET['q'])) {
	$q = $_GET['q'];
	$sql_where = "WHERE nama LIKE '{$q}%'";
}
$title = 'Data Barang';
include_once 'koneksi.php';

$sql = 'SELECT * FROM data_barang';
$sql_count = "SELECT COUNT(*) FROM data_barang";
if (isset($sql_where)) {
	$sql .= $sql_where;
	$sql_count .= $sql_where;
} 
$result_count = mysqli_query($conn, $sql_count);
$count = 0;
if ($result_count) {
	$r_data = mysqli_fetch_row($result_count);
	$count = $r_data[0];
}
$per_page = 1;
$num_page = ceil($count / $per_page);
$limit = $per_page;
if (isset($_GET['page'])) {
	$page = $_GET['page'];
	$offset = ($page - 1) * $per_page;
} else {
	$offset = 0;
	$page = 1;
}
$sql .= " LIMIT {$offset}, {$limit}";
$result = mysqli_query($conn, $sql);
include_once 'header.php';

echo '<a href="tambah_barang.php" class="btn btn-large">Tambah Barang</a>';
?>
</div>
</div>
<div class="site_content">
<form action="index.php" method="get">
	<label for="q">Cari data: </label>
	<input type="text" id="q" name="q" class="input-q" value="<?php echo $q ?>">
	<input type="submit" name="submit" value="Cari" class="btn btn-primary">
</form>
</div>
<?php
if ($result):
?>
	<link href="style1.css" type="text/css" rel="stylesheet" />
	<table>
		<tr>
			<th>Gambar</th>
			<th>Nama Barang</th>
			<th>Kategori</th>
			<th>Harga Jual</th>
			<th>Harga Beli</th>
			<th>Stok</th>
			<th>Aksi</th>
		</tr>

	<?php while($row = mysqli_fetch_array($result)): ?>
		<tr>
			<td><?php echo  "<img src=\"{$row['gambar']}\" />";?></td>
			<td><?php echo $row['nama'];?></td>
			<td><?php echo $row['kategori'];?></td>
			<td><?php echo $row['harga_jual'];?></td>
			<td><?php echo $row['harga_beli'];?></td>
			<td><?php echo $row['stok'];?></td>
			<td>
				<a href="edit_barang.php?id=<?php echo $row['id_barang'];?>">Edit</a>
				<a href="hapus_barang.php?id=<?php echo $row['id_barang'];?>">Delete</a>
						</td>
					</tr>
				<?php endwhile; ?>
			</table>
			<link rel="stylesheet" href="style.css">
			<ul class="pagination">
				<li><a href="#">&laquo;</a></li>
				<?php for ($i=1; $i <= $num_page; $i++) {
					$link = "?page={$i}";
					if (!empty($q)) $link .= "&q={$q}";
					$class = ($page == $i ? 'active' : '');
					echo "<li><a class=\"{$class}\" href=\"{$link}\">{$i}</a></li>";
				} ?>
				<li><a href="#">&raquo;</a></li>
			</ul>
			
			<?php endif;
		include_once 'footer.php';
		?>
</body>
</html>