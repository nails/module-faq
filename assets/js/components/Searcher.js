class Searcher {
    constructor() {
        $('.js-store-searcher')
            .each((index, element) => {
                let $input = $(element);
                let api = $input.data('api');
                let isMultiple = $input.data('multiple') || false;
                let isClearable = $input.data('clearable') || false;

                if (api) {
                    //  @todo (Pablo - 2018-07-01) - Build a select2 interface for searching items
                }
            });
    }
}

export default Searcher;
