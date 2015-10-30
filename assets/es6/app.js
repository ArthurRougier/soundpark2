var Player       = require('./player3.js');
var Liker         = require('./Liker.js');

SC.initialize({
      client_id: "17f3a8c69cb36c955df82f908611e27e"
  });

    var trackListTest = ['https://soundcloud.com/nicolashaelg/nicolas-haelg-alfie-rhodes-callin-your-name-feat-syren-1',
    'https://www.youtube.com/watch?v=izkqPdVAdL4',
    'https://soundcloud.com/thefallingapple/tracy-chapman-fast-car-bauke-top-remix',
    'https://www.youtube.com/watch?v=JrlfFTS9kGU',
    'https://www.youtube.com/watch?v=h_aLbagloMk',
    'https://soundcloud.com/chris-meid/chris-meid-bergershaqiri-eye-of-the-tiger-ft-drew-tabor',
    'https://www.youtube.com/watch?v=BBtLMLQfiRo',
    'https://soundcloud.com/vaguewave/morcheeba-enjoy-the-ride-vague-wave-remix',
    'https://soundcloud.com/probcause/probcause-gramatik-back-to-the-future',
    'https://www.youtube.com/watch?v=jdYJf_ybyVo',
    'https://soundcloud.com/artifakts/hot-like-sauce-remix',
    'https://www.youtube.com/watch?v=hc9VXLtgw5g',
    'https://www.youtube.com/watch?v=ESXgJ9-H-2U',
    'https://www.youtube.com/watch?v=OPf0YbXqDm0',
    'https://www.youtube.com/watch?v=4HLY1NTe04M',
    'https://soundcloud.com/alexcruz/alex-cruz-ft-anna-renee-melle-kuil-haunting-original-vocal-mix',
    'https://soundcloud.com/robotaki/autograf-dream-robotaki-remix',
    'https://soundcloud.com/fdvm/fdvm-feat-josh-wantie-brightest-light'
    ];


  var arrowSelectors      = ["#left_arrow", "#right_arrow"];
  var likeDislikeSelectors  = ["#plus_one", "#minus_one"];
  var playerTest        = new Player(trackListTest, '.slider', '.play', arrowSelectors);
  var likerTest         = new Liker(likeDislikeSelectors, playerTest);