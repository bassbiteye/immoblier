<template>
  <div>

    <div class="row">
      <!-- ============================================================== -->
      <!-- sales  -->
      <!-- ============================================================== -->
      <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
        <div class="card border-3 border-top border-top-primary">
          <div class="card-body">
            <h5 class="text-muted">Biens</h5>
            <div class="metric-value d-inline-block">
              <h1 class="mb-1" v-if="bien">{{bien}}</h1>
            </div>
           
          </div>
        </div>
      </div>
      <!-- ============================================================== -->
      <!-- end sales  -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- new customer  -->
      <!-- ============================================================== -->
      <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
        <div class="card border-3 border-top border-top-primary">
          <div class="card-body">
            <h5 class="text-muted">Clients</h5>
            <div class="metric-value d-inline-block">
              <h1 class="mb-1" v-if="client">{{client}}</h1>
            </div>
          
          </div>
        </div>
      </div>
      <!-- ============================================================== -->
      <!-- end new customer  -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- visitor  -->
      <!-- ============================================================== -->
      <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
        <div class="card border-3 border-top border-top-primary">
          <div class="card-body">
            <h5 class="text-muted">Bailleurs</h5>
            <div class="metric-value d-inline-block">
              <h1 class="mb-1" v-if="bailleur">{{bailleur}}</h1>
            </div>
           
          </div>
        </div>
      </div>
      <!-- ============================================================== -->
      <!-- end visitor  -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- total orders  -->
      <!-- ============================================================== -->
      <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
        <div class="card border-3 border-top border-top-primary">
          <div class="card-body">
            <h5 class="text-muted">Utilsateurs</h5>
            <div class="metric-value d-inline-block">
              <h1 class="mb-1" v-if="user">{{user}}</h1>
            </div>
          
          </div>
        </div>
      </div>
      <!-- ============================================================== -->
      <!-- end total orders  -->
      <!-- ============================================================== -->
    </div>
     <div class="row">
      <!-- ============================================================== -->
     
      <!-- ============================================================== -->
     <!-- total orders  -->
      <!-- ============================================================== -->
      <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
        <div class="card border-3 border-top border-top-primary">
          <div class="card-body">
            <h5 class="text-muted">Solde Alawa</h5>
            <div class="metric-value d-inline-block">
              <h1 class="mb-1">{{Soldealawa[0].solde}}</h1>
            </div>
            
          </div>
        </div>
      </div>
      <!-- ============================================================== -->
      <!-- end total orders  -->
   
      <!-- ============================================================== -->
      <!-- new customer  -->
      <!-- ============================================================== -->
      <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
        <div class="card border-3 border-top border-top-primary">
          <div class="card-body">
            <h5 class="text-muted">Commission</h5>
            <div class="metric-value d-inline-block">
              <h1 class="mb-1">{{Commission[0].commission}} fcfa</h1>
            </div>
          
          </div>
        </div>
      </div>
      <!-- ============================================================== -->
      <!-- end new customer  -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- visitor  -->
      <!-- ============================================================== -->
      <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
        <div class="card border-3 border-top border-top-primary">
          <div class="card-body">
            <h5 class="text-muted">      solde Bailleurs</h5>
            <div class="metric-value d-inline-block">
              <h1 class="mb-1">{{soldeBailleur[0].solde}} fcfa</h1>
            </div>
           
          </div>
        </div>
      </div>
      <!-- ============================================================== -->
      <!-- end visitor  -->
      <!-- ============================================================== -->
      <!-- sales  -->
      <!-- ============================================================== -->
      <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
        <div class="card border-3 border-top border-top-primary">
          <div class="card-body">
            <h5 class="text-muted">solde Clients</h5>
            <div class="metric-value d-inline-block">
              <h1 class="mb-1">{{sommeClient[0].solde}} fcfa</h1>
            </div>
         
          </div>
        </div>
      </div>
      <!-- ============================================================== -->
      <!-- end sales  -->
      <!-- ============================================================== -->
        <!-- ============================================================== -->
    </div>
  </div>
</template>

<script>
import notFoundComponentVue from "./notFoundComponent.vue";

export default {
  components: {
    "not-found": notFoundComponentVue
  },
  mounted() {
    this.countuser();
    this.countclients();
    this.countbiens();
    this.countbailleurs();
    this.soldebailleur();
    this.sommeclient();
    this.commission();
    this.soldealawa();
  },

  data() {
    return {
      user: "",
      bailleur: "",
      client: "",
      bien: "",
      soldeBailleur:"",
      sommeClient:"",
      Commission:"",
      Soldealawa:''
    };
  },
  methods: {
    countuser() {
      axios.get("api/countuser").then(response => {
        this.user = response.data;
      });
    },
    countclients() {
      axios.get("api/countclients").then(response => {
        this.client = response.data;
      });
    },
    countbailleurs() {
      axios.get("api/countbailleurs").then(response => {
        this.bailleur = response.data;
      });
    },
    countbiens() {
      axios.get("api/countbiens").then(response => {
        this.bien = response.data;
      });
    },
    soldebailleur(){
          axios.get("api/soldebailleur").then(response => {
        this.soldeBailleur = response.data;
      });
    },
    sommeclient(){
         axios.get("api/sommeclient").then(response => {
        this.sommeClient = response.data;
      });
       
  },commission(){
        axios.get("api/commission").then(response => {
        this.Commission = response.data;
      });
  },
  soldealawa(){
     axios.get("api/soldealawa").then(response => {
        this.Soldealawa = response.data;
      });
  }

  }
};
</script>
