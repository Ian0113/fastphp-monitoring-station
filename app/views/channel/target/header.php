<div class="inline">
    <h1>Channel:<?php print $channel['name'] ?>
    <a
    href='javascript:void(0)'
    class='right'
    id='Btn'
    data-modal-btn=<?php print('"Edit'.$channel['name'].'Modal"'); ?>
    onclick='addModal(this)'
    style='padding:0 5px;'
    >
    <i class='fas fa-edit right'></i>
    </a>
    <a
    href='javascript:void(0)'
    class='right'
    id='Btn'
    data-modal-btn='Update<?php print $channel['name'] ?>Modal'
    onclick='addModal(this)'
    style='padding:0 5px;'
    >
    <i class="fas fa-arrow-up right"></i>
    </a>
    </h1>
</div>
<hr>

