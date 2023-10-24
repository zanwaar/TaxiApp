@push('css')
<style>
    .star-rating {
        line-height: 32px;
        font-size: 1.25em;
    }

    .star-rating .fas {
        color: yellow;
    }
</style>
@endpush
@push('js')
<script>
    var $star_rating = $('.star-rating .r');

    var SetRatingStar = function() {
        return $star_rating.each(function() {
            if (parseInt($star_rating.siblings('input.rating-value').val()) >= parseInt($(this).data('rating'))) {
                return $(this).removeClass('far').addClass('fas');
            } else {
                return $(this).removeClass('fas').addClass('far');
            }
        });
    };

    $star_rating.on('click', function() {
        $star_rating.siblings('input.rating-value').val($(this).data('rating'));
        return SetRatingStar();
    });

    SetRatingStar();
</script>
<script>
    $('form').submit(function() {
        @this.set('state.rating', $('#rating').val());
        @this.set('state.comment', $('#comment').val());
    })
</script>
@endpush