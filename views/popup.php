<div class="popup" id="popup">
    <div class="popup-content">
        <div class="popup-but">
            <div class="popup-test">
                <i class="fa-solid fa-circle-question"></i>
                <span><?php echo $errors[0]; ?></span>
            </div>
            <span id="closeErr">&times;</span>
        </div>
        <button type="button" id="btnOk">OK</button>
    </div>
</div>
</body>

<script>
    var popup = document.getElementById("popup");
    function showModal() {
        popup.style.display = "block";
    }
    var btnClose = document.getElementById("closeErr");
    btnClose.onclick = function() {
        popup.style.display = "none";
    }
    var btnOk = document.getElementById("btnOk");
    btnOk.onclick = function() {
        popup.style.display = "none";
    }
    popup.onclick = function (event) {
        if (event.target == popup && event.target !== btnClose) {
            // Không làm gì cả, modal vẫn hiển thị
        }
    };

    <?php if(!empty($errors)) {?>
    showModal();
<?php }?>