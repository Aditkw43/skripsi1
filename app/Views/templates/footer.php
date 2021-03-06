<!-- Scripts -->
<!-- Libs JS -->
<script src="/assets/libs/jquery/dist/jquery.min.js"></script>
<script src="/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="/assets/libs/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="/assets/libs/feather-icons/dist/feather.min.js"></script>
<script src="/assets/libs/prismjs/components/prism-core.min.js"></script>
<script src="/assets/libs/prismjs/components/prism-markup.min.js"></script>
<script src="/assets/libs/prismjs/plugins/line-numbers/prism-line-numbers.min.js"></script>
<script src="/assets/libs/apexcharts/dist/apexcharts.min.js"></script>
<script src="/assets/libs/dropzone/dist/min/dropzone.min.js"></script>

<!-- clipboard -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.12/clipboard.min.js"></script>

<!-- Theme JS -->
<script src="/assets/js/theme.min.js"></script>

<!-- My JS -->
<script>
    function showDiv(element) {
        if (element.value == 'cuti_semester') {
            document.getElementById('hidden_tanggal_cuti_semester').style.display = '';
            document.getElementById('hidden_tanggal_cuti_sementara').style.display = 'none';
        } else if (element.value == 'cuti_sementara') {
            document.getElementById('hidden_tanggal_cuti_sementara').style.display = '';
            document.getElementById('hidden_tanggal_cuti_semester').style.display = 'none';
        } else {
            document.getElementById('hidden_tanggal_cuti_sementara').style.display = 'none';
            document.getElementById('hidden_tanggal_cuti_semester').style.display = 'none';
        }
    }
</script>