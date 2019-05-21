<footer>
	Copyright
	<a href="">SHARE-LIST</a>
	. All Rights Reserved.
</footer>

<script src="js/vendor/jquery-2.2.2.min.js"></script>
<script>
	$(function(){
		// メッセージ表示
		var $jsShowMsg = $('#js-show-msg');
		var msg = $jsShowMsg.text();
		if(msg.replace(/^[\s ]+|[\s ]+$/g, "").length){
			$jsShowMsg.slideToggle('slow');
			setTimeout(function(){ $jsShowMsg.slideToggle('slow'); },5000);
		}

		// 画像ライブプレビュー
		var $dropArea = $('.area-drop');
		var $fileInput = $('.input-file');
		$dropArea.on('dragover', function(e){
			e.stopPropagation();
			e.preventDefault();
			$(this).css('border','3px #CCC dashed');
		});
		$dropArea.on('dragleave', function(e){
			e.stopPropagation();
			e.preventDefault();
			$(this).css('border','none');
		});
		$fileInput.on('change', function(e){
			$dropArea.css('border', 'none');
			var file = this.files[0],
					$img = $(this).siblings('.prev-img'),
					fileReader = new FileReader();

			fileReader.onload = function(event){
				$img.attr('src', event.target.result).show();
			};

			fileReader.readAsDataURL(file);

		});
		
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