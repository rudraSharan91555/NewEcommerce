<template>
    <Layout>
        <template v-slot:content="{ cartProduct, cartTotal }">
            <main>
                <section class="breadcrumb bg-dark text-white p-3 rounded">
                    <div class="container py-5 mt-5">
                        <div class="row d-flex justify-content-center align-items-center">
                            <div class="col-lg-10 col-xl-8">
                                <div class="card" style="border-radius: 10px;">
                                    <div class="card-header px-4 py-5">
                                        <h5 class="text-muted mb-0">Thanks for your Order!</h5>
                                    </div>

                                    <!-- Debugging: Console Log -->
                                    <pre>{{ cartProduct }}</pre>

                                    <div v-if="cartProduct.length === 0">
                                        <p>No products in the cart!</p>
                                    </div>

                                    <!--  Order Items Loop -->
                                    <div v-for="item in cartProduct" :key="item.id" class="card-body p-4">
                                        <div class="card shadow-0 border mb-4">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <img :src="item.products?.[0]?.image" class="img-fluid" alt="Product">
                                                    </div>
                                                    <div class="col-md-2 text-center">
                                                        <p class="text-muted mb-0">{{ item.products?.[0]?.name || 'N/A' }}</p>
                                                    </div>
                                                    <div class="col-md-2 text-center">
                                                        <p class="text-muted mb-0">Qty: {{ item.qty }}</p>
                                                    </div>
                                                    <div class="col-md-2 text-center">
                                                        <p class="text-muted mb-0">Rs {{ (item.products?.[0]?.product_attributes?.[0]?.price || 0) * item.qty }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--  Total Price -->
                                    <div class="card-footer px-4 py-5" style="background-color: #a8729a;">
                                        <h5 class="d-flex justify-content-end text-white text-uppercase mb-0">
                                            Total Paid: <span class="h2 mb-0 ms-2">Rs {{ cartTotal }}</span>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
        </template>
    </Layout>
</template>

<script>
import Layout from './Layout.vue';

export default {
    name: 'OrderDetail',
    components: { Layout },
    mounted() {
        console.log("OrderDetail Mounted!");
    }
}
</script>
