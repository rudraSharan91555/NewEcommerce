export function getUrlList() {
    const baseUrl = "http://127.0.0.1:8000/api";
    return {
        // getHeaderCategoriesData: baseUrl + "/getHeaderCategoriesData",
        getHeaderCategoriesData : ''+baseUrl+'/getHeaderCategoriesData', 
        getHomeData : ''+baseUrl+'/getHomeData', 
        getCategoryData : ''+baseUrl+'/getCategoryData',
        getProductData : ''+baseUrl+'/getProductData',
    };
}

export default getUrlList;
