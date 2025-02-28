export function getUrlList() {
    const baseUrl = "http://127.0.0.1:8000/api";
    return {
        getHeaderCategoriesData : ''+baseUrl+'/getHeaderCategoriesData', 
        getHomeData : ''+baseUrl+'/getHomeData', 
        getCategoryData : ''+baseUrl+'/getCategoryData',
        getUserData : ''+baseUrl+'/getUserData',
    };
}

export default getUrlList;
