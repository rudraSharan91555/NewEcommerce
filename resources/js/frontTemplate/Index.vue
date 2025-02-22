<template>
    <Layout>
        <!-- main-area -->

        <template v-slot:content="slotProps">

            <!-- slider-area-end -->
            <HomeBanner :Banner="homeBanner" />
            <HomeCategories :homeCategory="getShortArray(3)" />
            <TrendingProducts :homeCategory="getShortArray(9)" :showActiveClass="showActiveClass"  :addToCart="slotProps.addToCart" />

            <NewArrivalProducts :homeCategory="getShortArray(9)" :homeProducts="homeProducts"
                :showActiveClass="showActiveClass" :addToCart="slotProps.addToCart" />
            <!-- shoes-banner-area -->
            <section class="shoes-banner-area">
                <div class="container">
                    <div class="shoes-banner-active">
                        <div class="shoes-banner-bg" data-background="/front_assets/img/bg/shoes-banner_bg.jpg">
                            <div class="row">
                                <div class="col-12">
                                    <div class="shoes-banner-content">
                                        <h6>Athletes Shoes</h6>
                                        <h2>9 Best <span>Shoes for</span> Standing All Day Review 2020</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="shoes-banner-bg" data-background="/front_assets/img/bg/shoes-banner_bg.jpg">
                            <div class="row">
                                <div class="col-12">
                                    <div class="shoes-banner-content">
                                        <h6>Athletes Shoes</h6>
                                        <h2>3 Best <span>Shoes for</span> Standing All Day Review 2021</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="shoes-banner-bg" data-background="/front_assets/img/bg/shoes-banner_bg.jpg">
                            <div class="row">
                                <div class="col-12">
                                    <div class="shoes-banner-content">
                                        <h6>Athletes Shoes</h6>
                                        <h2>8 Best <span>Shoes for</span> Standing All Day Review 2021</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- promo-services -->
            <section class="promo-services pt-70 pb-25">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-3 col-md-6 col-sm-8">
                            <div class="promo-services-item mb-40">
                                <div class="icon"><img src="/front_assets/img/icon/promo_icon01.png" alt=""></div>
                                <div class="content">
                                    <h6>payment & delivery</h6>
                                    <p>Delivered, when you receive arrives</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-8">
                            <div class="promo-services-item mb-40">
                                <div class="icon"><img src="/front_assets/img/icon/promo_icon02.png" alt=""></div>
                                <div class="content">
                                    <h6>Return Product</h6>
                                    <p>Retail, a Product Return Process</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-8">
                            <div class="promo-services-item mb-40">
                                <div class="icon"><img src="/front_assets/img/icon/promo_icon03.png" alt=""></div>
                                <div class="content">
                                    <h6>money back guarantee</h6>
                                    <p>Options Including 24/7</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-8">
                            <div class="promo-services-item mb-40">
                                <div class="icon"><img src="/front_assets/img/icon/promo_icon04.png" alt=""></div>
                                <div class="content">
                                    <h6>Quality support</h6>
                                    <p>Support Options Including 24/7</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <HomeBrands :homeBrands="homeBrands" />

        </template>

    </Layout>
</template>
<script>
import Layout from './Layout.vue'
import axios from 'axios';
import getUrlList from '../provider.js';
import HomeBanner from './components/HomeBanner.vue';
import HomeCategories from './components/HomeCategories.vue';
import TrendingProducts from './components/TrendingProducts.vue';
import NewArrivalProducts from './components/NewArrivalProducts.vue';
import HomeBrands from './components/HomeBrands.vue';

export default {
    name: 'Index',
    components: {
        Layout,
        HomeBanner,
        HomeCategories,
        TrendingProducts,
        NewArrivalProducts,
        HomeBrands
    },
    data() {
        return {
            homeBanner: [],
            homeCategories: [],
            homeBrands: [],
            homeProducts: [],
        }
    },
    mounted() {
        console.log('Index file call');
        this.getHomeBanner();
    },
    methods: {
        showActiveClass(type, index) {
            // type 1= 1->cat type==2 products
            if (type == 1 && index == 0) {
                return 'active';
            } else if (type == 2 && index == 0) {
                return 'show active';
            } else {
                return '';
            }
        },
        getShortArray(size) {
            return this.homeCategories.slice(0, size);
        },

        async getHomeBanner() {
            try {
                let data = await axios.get(getUrlList().getHomeData);
                // console.log(data);
                // console.log(data.data.data.data.categories);
                if (data.status == 200 && data.data.data.data.banner.length > 0) {
                    this.homeBanner = data.data.data.data.banner;
                    this.homeCategories = data.data.data.data.categories;
                    this.homeBrands = data.data.data.data.brands;
                    this.homeProducts = data.data.data.data.products;
                    // console.log(this.headerCategories);
                    this.catCount = 0;
                } else {
                    console.log('Data not found');
                    // console.log(data);
                }
            } catch (error) {
                console.log('Error');
            }
            console.log(this.homeBrands);
        }
    }
}
</script>