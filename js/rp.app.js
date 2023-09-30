$(document).ready(function() {

    // Count the number of .review-product-container elements
    var containerCount = $(".review-product-container").length;

    // Iterate over each .review-product-container element
    $(".review-product-container").each(function(index) {
        // Update the .total-no span with the total count
        $(this).find(".total-no").text(containerCount);

        // Update the .win-no span with the current index + 1
        $(this).find(".win-no").text(index + 1);
    });
    
    $(".rp-star-rating").each(function() {
        var $this = $(this);
        var ratingScore = $this.data("rating-score");
        
        $this.starRating({
            totalStars: ratingScore,
            starSize: 15,
            emptyColor: "lightgray",
            hoverColor: "#FFA41C",
            activeColor: "#FFA41C",
            initialRating: 25,
            strokeWidth: 0,
            useGradient: false,
            minRating: 1,
            readOnly: true,
            callback: function(currentRating, $el) {
                alert("rated " + currentRating);
                console.log("DOM element ", $el);
            }
        });
    });
});