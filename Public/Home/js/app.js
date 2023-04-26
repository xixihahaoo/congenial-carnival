/**
 * seajs配置  
 */
 

seajs.config({

    base: '/content',

    // 别名（缩写）
    alias: {
        // lib
        '$': 'assets/lib/jquery/1.0/main',
        '_': 'assets/lib/lodash/1.0/main',
        'moment': 'assets/lib/moment/2.10.3/moment',
    
        // lang
        'modLoader': 'lang/mod-loader',
        'dataStore': 'lang/data-store',
        'observer': 'lang/observer',
        'delayer': 'lang/' +
        '' +
        '' +
        'delayer',
        'class': 'lang/class',
        'net': 'lang/net',
        'log': 'lang/log',

        // util
        'util/lazyload': 'util/lazyload/1.0/lazyload',
        'util/clipboard': 'util/clipboard/1.0/main',

        // ui
        'ui/msgbox': 'ui/msgbox/1.0/main',
        'ui/loading': 'ui/loading/1.0/main',
        'ui/menu': 'ui/menu/1.0/main',
        'ui/address': 'ui/address/1.0/main',
        'ui/sline': 'ui/chart/sline/1.0/main',
        'ui/kline': 'ui/chart/kline/1.0/main',
        'ui/tick': 'ui/chart/tick/1.0/main',

        // data
        'data/province': 'data/address/1.0/province',
        'data/city': 'data/address/1.0/city',
        'data/taiwan': 'data/address/1.0/taiwan',
        'data/hongkong': 'data/address/1.0/hongkong',
        'data/contract': 'data/contract/1.0/main',
        'data/holidays': 'data/holidays/1.0/main',

        // external
        'ext/share': 'ext/share/1.0/main'
    },

    // 路径（缩写）
    paths: {
        'lang': 'assets/js/lang',
        'util': 'assets/js/util',
        'ui': 'assets/js/ui',
        'ext': 'assets/js/ext',
        'mod': 'assets/js/biz/mod',
        'page': 'assets/js/biz/page',
        'site': 'assets/js/biz/site'
    },

    map: [
        [/(\.js)$/, '$1?_=151117001']
    ],

    charset: 'UTF-8'
});
