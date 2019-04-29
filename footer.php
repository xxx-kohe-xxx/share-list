<footer>
	Copyright
	<a href="">SHARE-LIST</a>
	. All Rights Reserved.
</footer>

<script src="js/vendor/jquery-2.2.2.min.js"></script>
<script>
	$(function(){
		var $jsShowMsg = $('#js-show-msg');
		var msg = $jsShowMsg.text();
		if(msg.replace(/^[\s ]+|[\s ]+$/g, "").length){
			$jsShowMsg.slideToggle('slow');
			setTimeout(function(){ $jsShowMsg.slideToggle('slow'); },5000);
		}
		
		// お気に入り登録・削除
		var $like,
				likeListId;
		$like = $('.js-click-like') || null; // .js-click-like が存在しない場合にnullが入る
		likeListId = $like.data('listid') || null; 
		console.log(likeListId);				
		if(likeListId !== undefined && likeListId !== null){
			$like.on('click',function(){
				var $this = $(this);
				$.ajax({
					type: "post",
					url: "ajaxLike.php",
					data: {listId : likeListId}
				}).done(function(data){
					console.log('Ajax Success');
					// クラス属性をToggleで付け外しする
					$this.toggleClass('active');
				}).fail(function(msg){
					console.log('Ajax Error');
				});
			});
		}else{
			console.log('linkListIdが未定義 または null です。');
		}

	});
</script>