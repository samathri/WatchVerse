<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luxury Watch Slider</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .watch-slider {
            position: relative;
            padding: 40px 0;
            background: #fff;
            overflow: hidden;
            margin-top: -300px;
        }
        
        .carousel {
            height: 800px !important;
            perspective: 1000px;
        }
        
        .carousel-item {
            width: 300px !important;
            padding: 20px;
            text-align: center;
        }
        
        .watch-img {
            max-width: 100%;
            height: auto;
            margin-bottom: 15px;
        }
        
        .watch-brand {
            font-size: 14px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        
        .watch-model-slider {
            font-size: 12px;
            color: #666;
            margin-bottom: 10px;
        }
        
        .rating {
            color: #FC8C1C;
            font-size: 16px;
            margin-bottom: 10px;
        }
        
        .nav-buttons {
            position: absolute;
            top: 50%;
            width: 100%;
            transform: translateY(-50%);
            z-index: 1;
        }
        
        .nav-btn {
            position: absolute;
            background: #fff;
            border: 1px solid #ddd;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .prev {
            left: 10px;
        }
        
        .next {
            right: 10px;
        }
        
        .action-icons {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        
        .action-icon {
            background: #fff;
            border: 1px solid #ddd;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .action-icon.active {
            background: #FC8C1C;
            border-color: #FC8C1C;
            color: white;
        }

        .action-icon:hover {
            transform: scale(1.1);
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .carousel-item.active .watch-card {
            transform: scale(1.1);
            transition: transform 0.3s ease;
        }

        /* Custom indicator styles */
        .carousel-indicators {
            position: absolute;
            bottom: 50px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            z-index: 2;
        }

        .indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #ddd;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .indicator.active {
            background-color: #FC8C1C;
        }
        .html, body {
    overflow: hidden;
    height: 100%;
    margin: 0;
    padding: 0;
}

/* Watch Selector Section */
.watch-selector-section {
      background: white;
      padding: 40px 0;
    }
    
    .filter-btn {
      background: transparent;
      border: 2px solid orange;
      padding: 8px 16px;
      color: orange;
      cursor: pointer;
      border-radius: 5px;
      margin: 0 5px;
    }
    
    .watch-carousel-container {
      max-width: 1000px;
      margin: auto;
      position: relative;
    }
    
    .watch-carousel {
      display: flex;
      transition: transform 0.4s ease;
      overflow-x: hidden;
      max-width: 90%;
    }
    
    .watch-card {
      min-width: 160px;
      text-align: center;
    }
    
    .featured-watch {
      font-weight: bold;
    }
    
    .watch-card img {
      width: 100%;
      max-width: 150px;
      border-radius: 8px;
    }
    
    .featured-image {
      max-width: 180px;
    }
    
    .watch-name {
      font-size: 1rem;
      font-weight: bold;
      margin-top: 10px;
    }
    
    .watch-model {
      font-size: 0.9rem;
      color: gray;
    }
    
    .watch-rating {
      color: orange;
    }
    
    .carousel-btn {
      background: transparent;
      border: none;
      font-size: 24px;
      cursor: pointer;
      color: #333;
    }

    .watch-finder-s {
            text-align: center;
            margin-top: 50px;
        }
        .watch-title-s {
            font-size: 24px;
            font-weight: bold;
            color: #000 !important;
        }
        .btn-group-s {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 20px;
        }
        .btn-custom-s {
            border: 2px solid #FC8C1C;
            background: transparent;
            color: #FC8C1C;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 8px;
            transition: 0.3s ease-in-out;
            cursor: pointer;
            min-width: 120px;
        }
        .btn-custom-s:hover {
            background: #FC8C1C;
            color: #fff;
        }


    </style>
</head>
<body>


<div class="watch-finder-s">
    <h2 class="watch-title-s">Let's Find You A Watch</h2>
    <div class="btn-group-s">
        <button class="btn-custom-s">Color</button>
        <button class="btn-custom-s">Material</button>
        <button class="btn-custom-s">Type</button>
        <button class="btn-custom-s">Brand</button>
    </div>
</div>



    <div class="container">
        <div class="watch-slider">
            <div class="nav-buttons">
                <button class="nav-btn prev">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="nav-btn next">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            
            <div class="carousel">
                <div class="carousel-item">
                    <div class="action-icons">
                        <span class="action-icon" data-action="favorite"><i class="fas fa-heart"></i></span>
                        <span class="action-icon" data-action="view"><i class="fas fa-eye"></i></span>
                        <span class="action-icon" data-action="lock"><i class="fas fa-lock"></i></span>
                    </div>
                    <img src="images/w11.png" alt="TagHeuer" class="watch-img">
                    <h3 class="watch-brand">TagHeuer</h3>
                    <p class="watch-model-slider">Sky Dweller</p>
                    <div class="rating">★★★☆☆</div>
                </div>
                
                <div class="carousel-item">
                    <div class="action-icons">
                        <span class="action-icon" data-action="favorite"><i class="fas fa-heart"></i></span>
                        <span class="action-icon" data-action="view"><i class="fas fa-eye"></i></span>
                        <span class="action-icon" data-action="lock"><i class="fas fa-lock"></i></span>
                    </div>
                    <img src="images/w11.png" alt="Patek Philippe" class="watch-img">
                    <h3 class="watch-brand">Patek Philippe</h3>
                    <p class="watch-model-slider">Nautilus</p>
                    <div class="rating">★★★★☆</div>
                </div>
                
                <div class="carousel-item">
                    <div class="action-icons">
                        <span class="action-icon" data-action="favorite"><i class="fas fa-heart"></i></span>
                        <span class="action-icon" data-action="view"><i class="fas fa-eye"></i></span>
                        <span class="action-icon" data-action="lock"><i class="fas fa-lock"></i></span>
                    </div>
                    <img src="images/w11.png" alt="IWC" class="watch-img">
                    <h3 class="watch-brand">IWC</h3>
                    <p class="watch-model-slider">Constellation Globemaster</p>
                    <div class="rating">★★★☆☆</div>
                </div>
                
                <div class="carousel-item">
                    <div class="action-icons">
                        <span class="action-icon" data-action="favorite"><i class="fas fa-heart"></i></span>
                        <span class="action-icon" data-action="view"><i class="fas fa-eye"></i></span>
                        <span class="action-icon" data-action="lock"><i class="fas fa-lock"></i></span>
                    </div>
                    <img src="images/w11.png" alt="Rolex" class="watch-img">
                    <h3 class="watch-brand">Rolex</h3>
                    <p class="watch-model-slider">Conquest Chrono</p>
                    <div class="rating">★★☆☆☆</div>
                </div>
                
                <div class="carousel-item">
                    <div class="action-icons">
                        <span class="action-icon" data-action="favorite"><i class="fas fa-heart"></i></span>
                        <span class="action-icon" data-action="view"><i class="fas fa-eye"></i></span>
                        <span class="action-icon" data-action="lock"><i class="fas fa-lock"></i></span>
                    </div>
                    <img src="images/w11.png" alt="Tissot" class="watch-img">
                    <h3 class="watch-brand">Tissot</h3>
                    <p class="watch-model-slider">Heritage Mecanique</p>
                    <div class="rating">★★★★☆</div>
                </div>
                <div class="carousel-indicators"></div>
            </div>

        </div>
    </div>

    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        $(document).ready(function(){
            // Initialize carousel
            $('.carousel').carousel({
                padding: 200,
                numVisible: 3,
                indicators: false,
                shift: 50,
                onCycleTo: function(currentItem) {
                    updateIndicators($(currentItem).index());
                }
            });
            
            // Navigation buttons
            $('.prev').click(function() {
                $('.carousel').carousel('prev');
            });
            
            $('.next').click(function() {
                $('.carousel').carousel('next');
            });

            // Action icons click handlers
            $('.action-icon').click(function(e) {
                e.preventDefault();
                const action = $(this).data('action');
                $(this).toggleClass('active');
                
                // You can add specific functionality for each action
                switch(action) {
                    case 'favorite':
                        // Handle favorite action
                        const isFavorited = $(this).hasClass('active');
                        console.log('Favorite:', isFavorited);
                        break;
                    case 'view':
                        // Handle view action
                        const isViewed = $(this).hasClass('active');
                        console.log('Viewed:', isViewed);
                        break;
                    case 'lock':
                        // Handle lock action
                        const isLocked = $(this).hasClass('active');
                        console.log('Locked:', isLocked);
                        break;
                }
            });

            // Create custom indicators
            const numItems = $('.carousel-item').length;
            const indicatorsContainer = $('.carousel-indicators');
            
            for (let i = 0; i < numItems; i++) {
                const indicator = $('<div>')
                    .addClass('indicator')
                    .data('index', i)
                    .appendTo(indicatorsContainer);
                
                indicator.click(function() {
                    const index = $(this).data('index');
                    $('.carousel').carousel('set', index);
                });
            }

            // Set initial active indicator
            updateIndicators(0);

            function updateIndicators(activeIndex) {
                $('.indicator').removeClass('active');
                $('.indicator').eq(activeIndex).addClass('active');
            }
        });
    </script>
</body>
</html>