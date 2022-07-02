$(document).ready(function () {
	$("#nim_result").html("");
	$(
		"#judulskripsi, #abstrak, #dp_satu, #dp_dua, #btnSubmit, #nama, #program_studi, #pendidikan_terakhir, #foto, #tambah"
	).prop("disabled", "disabled");

	// For Dosen

	// cek DP1 DP2
	$(".dosen_pembimbing").change(function () {
		var dp1 = $("#dp_satu").find(":selected").text();
		var dp2 = $("#dp_dua").find(":selected").text();
		if (dp1 == dp2) {
			Swal.fire(
				"Terjadi kesalahan",
				"Dosen Pembimbing Tidak Boleh Sama",
				"error"
			);
			$("#btnSubmit").prop("disabled", "disabled");
		} else {
			$("#btnSubmit").prop("disabled", false);
		}
	});

	const flashdata = $(".flash-data-for-dosen").data("flashdata");
	if (flashdata) {
		Swal.fire("Berhasil", "Dosen berhasil " + flashdata, "success");
	}

	// input only number page Lecture
	$("#nip").keypress(function (e) {
		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});

	$("#nip").change(function () {
		var nip = $("#nip").val();
		if (nip != "") {
			$.ajax({
				url: "control/checknip",
				method: "POST",
				data: {
					nip: nip,
				},
				success: function (data) {
					$("#nip_result").html(data);
					$("#nip_result").show();
				},
			});
		} else {
			$("#nama,#program_studi, #pendidikan_terakhir, #foto, #tambah").prop(
				"disabled",
				"disabled"
			);
			$("#nip_result").hide();
		}
	});

	$(".lecture-confirm-edit").click(function () {
		Swal.fire({
			title: "Apakah anda yakin?",
			text: "Data akan diubah",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Submit",
			cancelButtonText: "Batal",
		}).then((result) => {
			if (result.value) {
				$("#editLecture").submit();
			}
		});
	});

	// For Mahasiswa

	//check available NIM
	$("#nim").change(function () {
		var nim = $("#nim").val();
		if (nim != "") {
			$.ajax({
				url: "control/checknim",
				method: "POST",
				data: {
					nim: nim,
				},
				success: function (data) {
					$("#nim_result").html(data);
				},
			});
		}
	});

	const mahasiswa = $(".flash-data-for-mahasiswa").data("flashdata");
	if (mahasiswa) {
		Swal.fire("Berhasil", "Mahasiswa berhasil " + mahasiswa, "success");
	}

	$("#nim_mhs").keypress(function (e) {
		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});

	$("#nim_mhs").change(function () {
		var nim_mhs = $("#nim_mhs").val();
		if (nim_mhs != "") {
			$.ajax({
				url: "control/checkNIMBeforeAdd",
				method: "POST",
				data: {
					nim: nim_mhs,
				},
				success: function (data) {
					$("#nim_result").html(data);
				},
			});
		}
	});

	$(".mhs-confirm-edit").click(function () {
		Swal.fire({
			title: "Apakah anda yakin?",
			text: "Data mahasiswa akan berubah",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Submit",
			cancelButtonText: "Batal",
		}).then((result) => {
			if (result.value) {
				$(".editMahasiswa").submit();
				// document.location.href = href;
			}
		});
	});

	// For Skripsi

	// submit Skripsi
	$("#btnSubmit").click(function () {
		Swal.fire({
			title: "Apakah anda yakin?",
			text: "Skripsi yang sudah di input tidak bisa diubah!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Submit",
			cancelButtonText: "Batal",
		}).then((result) => {
			if (result.value) {
				$("#submitSkripsi").submit();
			}
		});
	});

	const skripsi = $(".flash-data-for-skripsi").data("flashdata");
	if (skripsi) {
		Swal.fire("Berhasil", "Skripsi berhasil " + skripsi, "success");
	}

	// input only number in Skripsi page
	$("#nim").keypress(function (e) {
		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});

	// For Stopword

	// For Kata Imbuhan

	// For Main Page

	function GetTitleFromDb() {
		$("#result").html("");
		$("#wrapper").css("height", "100%");
		$("#overlay").show();
		var keyword = $("#keyword").val();
		if (keyword != "") {
			$.ajax({
				url: "home/cari/searchtitle",
				method: "POST",
				data: {
					judul_skripsi: keyword,
				},

				success: function (data) {
					$("#overlay").hide();
					$("#wrapper")
						.css("height", "100%", "border", "3px solid black")
						.show("slow", 1000);
					$("#result").html(data).show(1500);
				},
			});
		} else {
			$("#overlay").hide();
			Swal.fire("Kata kunci kosong");
		}
	}

	$("#btnSearch").click(function () {
		GetTitleFromDb();
	});

	$("#keyword").on("keyup", function (e) {
		if (e.keyCode == 13) {
			GetTitleFromDb();
		}
	});

	function showSpesificTitle() {
		$("#result").html("");
		if ($("#keyword").val() == "") {
			Swal.fire("Kata kunci kosong");
		} else {
			let titleInput = $("#keyword").val();

			$.ajax({
				url: `https://core.ac.uk:443/api-v2/articles/search/` + titleInput + ``,
				type: "GET",
				dataType: "JSON",
				data: {
					apiKey: "dZFV7OnLgA3XwDMyr9emoxBEzNaHTcsG",
					// 'page': 10,
					// 'pageSize': 100
				},
				success: function (result) {
					if (result.status === "OK") {
						let returnData = result.data;
						$.each(returnData, function (i, data) {
							if (
								data.publisher ==
									"Sekolah Tinggi Teknologi Adisutjipto Yogyakarta" ||
								data.repositories[0]["id"] == 13749 ||
								data.repositories[0]["id"] == 2432
							) {
								$("#wrapper").css("height", "100%");
								$("#result").append(
									`
                                        <div class="mt-2 pr-2 pl-2" style="background-color: RGB(0, 255, 255) ;border: 1px solid black; border-radius: 4px; color: #800080">
                                        <h4 style="color: #800080">` +
										data.title +
										`</h4>
                                        <h6 style="color: #800080">` +
										data.authors +
										`</h6>
                                        <small>` +
										data.contributors +
										`--` +
										data.repositories[0]["name"] +
										` </small></div>`
								);
							} else {
								console.log("TIDAK DITEMUKAN");
							}
						});
					}
				},
			});
		}
	}
});
