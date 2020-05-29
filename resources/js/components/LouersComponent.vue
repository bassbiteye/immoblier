<template>
  <div class="conteiner">
    <!-- bien -->

    <div class="row mt-5 no-print" v-if="$gate.isAdminOrBailleurs()">
      <div class="col-md-12" v-if="showTab">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">liste des biens</h3>

            <div class="card-tools">
              <!-- <button class="btn btn-success" @click="newModal">
                <i class="fas fa-user-plus fa fw"></i> Ajouter Equipement
              </button>-->
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table id="table" class="table table-hover">
              <thead>
                <tr>
                  <th>description</th>
                  <th>etat</th>
                  <th>type</th>
                  <th>prix</th>
                  <th>adresse</th>
                  <th>action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="biens in Biens.data" :key="biens.id">
                  <td>{{biens.details}}</td>
                  <td>{{biens.libelleE}}</td>
                  <td>{{biens.libelle}}</td>
                  <td>{{biens.prix}}</td>
                  <td>{{biens.adresse}}</td>

                  <td>
                    <button class="btn btn-success" @click="detail(biens)">
                      <i class="fas fa-rent-plus fa fw"></i> louer
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <pagination :data="Biens" @pagination-change-page="getResults"></pagination>
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>

    <section class="container-fluid" v-if="showForm">
      <div class="row">
        <div class="col-lg-6">
          <div class="row mt-3">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">client</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-6"></div>
                  </div>
                  <form @submit.prevent="findClient">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label class="form-control-label">numéro client</label>
                          <input
                            v-model="formT.numero"
                            type="text"
                            class="form-control"
                            placeholder="numero client"
                            @keyup.enter="findClient"
                            :class="{ 'is-invalid': form.errors.has('numero') }"
                          />

                          <has-error :form="formT" field="numero"></has-error>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <button
                          class="btn btn-success"
                          type="submit"
                          style="    margin-top: 29px;"
                        >rechercher</button>
                      </div>
                    </div>
                  </form>
                  <form @submit.prevent="finaliser">
                    <div class="row">
                      <div class="col-sm-6" v-if="form.client">
                        <div class="form-group">
                          <label>nom complet client</label>
                          <p>{{clientD.prenom}}_{{form.client}}</p>
                        </div>
                      </div>
                      <div class="col-sm-6" v-if="showForm2">
                        <div class="form-group">
                          <label class="form-control-label">caution</label>
                          <input
                            v-model="form.caution"
                            type="number"
                            class="form-control"
                            min="0"
                            placeholder="caution"
                            :class="{ 'is-invalid': form.errors.has('caution') }"
                          />
                          <has-error :form="form" field="caution"></has-error>
                        </div>
                      </div>
                    </div>
                    <div class="row" v-if="showForm2">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label class="form-control-label">montant payé</label>
                          <input
                            v-model="form.montantPaye"
                            type="number"
                            class="form-control"
                            min="0"
                            placeholder="montant payé"
                            :class="{ 'is-invalid': form.errors.has('montantPaye') }"
                          />
                          <has-error :form="form" field="montantPaye"></has-error>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label class="form-control-label">Date entrée</label>
                          <input
                            v-model="form.dateEntre"
                            type="date"
                            class="form-control"
                            placeholder="Date entrée"
                            :class="{ 'is-invalid': form.errors.has('dateEntre') }"
                          />
                          <has-error :form="form" field="dateEntre"></has-error>
                        </div>
                      </div>
                    </div>
                    <div class="row" v-if="showForm2">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label class="form-control-label">Commission</label>
                          <input
                            v-model="form.commission"
                            type="number"
                            class="form-control"
                            min="0"
                            placeholder="commission"
                            :class="{ 'is-invalid': form.errors.has('commission') }"
                          />
                          <has-error :form="form" field="commission"></has-error>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label class="form-control-label">taxe</label>
                          <input
                            v-model="form.taxes"
                            type="number"
                            class="form-control"
                            min="0"
                            placeholder="taxe"
                            :class="{ 'is-invalid': form.errors.has('taxes') }"
                          />
                          <has-error :form="form" field="taxes"></has-error>
                        </div>
                      </div>
                    </div>
                    <div class="row" v-if="showForm2">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label class="form-control-label">piece d’identité</label>
                          <input
                            type="file"
                            class="form-control"
                            @change="updatePiece"
                            name="piece"
                          />
                          <has-error :form="form" field="piece"></has-error>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label class="form-control-label">durée</label>
                          <input
                            v-model="form.durée"
                            type="number"
                            class="form-control"
                            placeholder="durée"
                            :class="{ 'is-invalid': form.errors.has('durée') }"
                          />
                          <has-error :form="form" field="durée"></has-error>
                        </div>
                      </div>
                    </div>
                    <div class="row" v-if="showForm2">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label class="form-control-label">derniere levé</label>
                          <input
                            type="file"
                            class="form-control"
                            @change="updateDernier"
                            name="dernierelevé"
                          />
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label class="form-control-label">commentaire</label>
                          <textarea
                            type="text"
                            class="form-control"
                            name="commentaire"
                            :class="{ 'is-invalid': form.errors.has('commentaire') }"
                          ></textarea>
                          <has-error :form="form" field="commentaire"></has-error>
                        </div>
                      </div>
                    </div>

                    <div clas="row" v-if="showForm2">
                      <button class="btn btn-primary" type="submit">finaliser</button>
                    </div>
                    <!--  ===================================================End table d'acces=======================================================   -->
                  </form>
                  <!-- /.card-body -->
                </div>
              </div>

              <!-- /.card -->
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="row mt-3">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Bien</h3>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                  <table class="table table-striped table-responsive-fluid">
                    <tbody>
                      <tr>
                        <td>
                          libelle
                          <input
                            :placeholder="form.libelle"
                            readonly
                            style="border:hidden;background:none;"
                          />
                        </td>
                      </tr>
                      <tr>
                        <td>
                          etat
                          <input
                            :placeholder="form.libelleE"
                            readonly
                            style="border:hidden;background:none;"
                          />
                        </td>
                      </tr>
                      <tr>
                        <td>
                          prix
                          <input
                            :placeholder="form.prix"
                            readonly
                            style="border:hidden;background:none;"
                          />
                        </td>
                      </tr>
                      <tr>
                        <td>
                          adresse
                          <input
                            :placeholder="form.adresse"
                            readonly
                            style="border:hidden;background:none;"
                          />
                        </td>
                      </tr>
                      <tr>
                        <td>
                          details
                          <input
                            :placeholder="form.details"
                            readonly
                            style="border:hidden;background:none;"
                          />
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <!--  ===================================================End table d'acces=======================================================   -->
                </div>
                <!-- /.card-body -->
              </div>

              <!-- /.card -->
            </div>
          </div>
        </div>
      </div>
    </section>

    <div v-if="!$gate.isAdminOrBailleurs()">
      <not-found></not-found>
    </div>
    <section class="content" v-if="contratL">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                  
                    <small class="float-right">Date: {{date|myDate}}</small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
             
                  <address>
                     <img src="/img/logo2.png" alt="">
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                 
                  <!-- <address>
                    <strong>{{client.prenom}}</strong>
                    <strong>{{client.nom}}</strong>

                    <br />
                    Phone: {{client.tel}}
                    <br />
                    sexe: {{client.sexe}}
                    <br />
                    adresse: {{client.adresse}}
                    <br />
                    profession: {{client.profession}}
                    <br />
                    nationalité: {{client.nationalite}}
                  </address> -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <img src="/img/gestion.png" alt="">
                  <p>
                    OUEST FOIRE DERRIERE St. SHELL
                    BP. 11 744 Dakar - Peytavin
                    Tél : (221) 33 820 71 90 / 33 820 71 21
                    Portable : (221)77 635 93 16
                    Email: mbolyama1@hotmail.com
                  </p>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                <p> <strong>  Loyer HT: ................... FCFA <br>
                  TOM 3.6%: ……………… FCFA <br>
                  D.E 2%: ……………. FCFA <br>
                  TOTAL: ……………… F CFA </strong> </p>
                 <h3 style="text-align:center"><strong> BAIL A USAGE D’HABITATION
                  A durée determinée (01 AN RENOUVELABLE) </strong> </h3>
                 <p><strong> Entre : </strong><br>
                  Le bailleur, Monsieur ………………………… Représenté par le CABINET IMMOBILIER MBOL YAMA, </p>
                 <p> Et 
                  Le preneur,<strong> ………………………………………… CNI N° : ……………………….. délivrée le ……………….. à Dakar, </strong><br> qui s’engage à prendre en location les locaux dont la désignation suit : ……………………………………………….. - <strong>Dakar. </strong><br>
                  Sans qu’il soit nécessaire de désigner les lieux plus amplement, les connaissant pour les avoir visités. </p>
                <p>  Cette location qui prendra effet le ………………………………..est à usage d’habitation. <br>
                  • Vu la loi N° 2014-03 portant baisse des loyers, <br>
                  • Vu le décret 2014-143 du 06 Février 2014,<br>
                  • Vu le décret 2014-144 du 06 Février 2014, <br>
                  • Vu la surface corrigée (voir copie et décompte par courrier séparé) et d’un commun accord, nous avons convenu ce qui suit :</p>
                 <p> Elle est consentie au prix de <strong> soixante treize mille six cents F CFA (73 600) FRANCS CFA TTC </strong> payable par terme mensuel <br> 
                 et d’avance au plus tard le 05 de chaque mois en cours. Tout mois entamé est dû. <br>
                  Le présent contrat est renouvelable annuellement par tacite reconduction<br>
                  Le loyer est portable et non quérable dans les bureaux du Cabinet Immobilier MBOL YAMA, Ouest Foire derrière la Station <br>
                   SHELL – B.P. 11 744 – Dakar. <br>
                  Le preneur reconnaît par la présente, prendre les lieux loués en bon état de réparations locatives et s’engage en conséquence à <br>
                   le rendre au moment de son départ, en parfait état d’entretien. <br>
                  Il s’engage formellement à acquitter exactement, pendant toute la durée de son occupation, les taxes d’égouts, d’eau,<br>
                   d’électricité, ses contributions personnelles et mobilières, le débouchage des égouts et la vidange des fosses sceptiques.<br>
                  Le locataire s’engage formellement à enregistrer ce contrat de location de manière à ce qu’aucun recours ne puisse être exercé <br>
                  à cet égard contre le propriétaire ou contre l’AGENCE IMMOBILIERE. <br>
                  Il s’engage à satisfaire toutes les charges de voirie de police et d’hygiène qui incombent aux locataires, y compris l’entretien et le remplacement des grillages moustiquaires endommagés, 
                  afin qu’aucun recours ne puisse être exercé à cet égard contre le propriétaire ou l’AGENCE IMMOBILIERE.</p>
                <strong>  CAUTION : le preneur verse à titre de caution la somme de ……………………………………. F CFA (………..) FCFA <br> équivalent à ……. (……..) mois de loyer . <br> </strong>
                 <p> Cette somme non productive d’intérêt, sera remboursée systématiquement après avoir rempli les cinq (05) conditions ci-après : <br>
                  a) Avoir restitué les lieux loués en parfait état locatif (notamment révision installation de plomberie, électricité, réfection <br>
                   des peintures & dans tous les cas la remise des clefs).<br>
                  b) Avoir obtenu de la SENEGALAISE DES EAUX (SDE) un quitus attestant le paiement des factures pendant la période d’occupation et <br>
                   jusqu’au jour du constat de départ.
                  c) Avoir rapporté la feuille de résiliation de son contrat d’électricité.<br>
                  d) Avoir payé son loyer jusqu’à la date échue du préavis ou du mois de la remise des clefs si celle-ci est postérieure au préavis.<br>
                  e) Avoir repris la peinture (la villa ou l’appartement que vous venez de louer a été entièrement repeinte).<br>
                  A défaut il sera prélevé sur la dite caution les sommes correspondantes aux frais de remise en état des lieux, ainsi que montant <br> des factures d’eau, d’électricité et de téléphone non réglé. Il demeure bien entendu que ces formalités de remise en état <br> 
                  et réalisation des travaux devront être effectués pendant la période du préavis.
                  Il est entendu que la présente location est régie par les Dispositions Civiles et Commerciales de la République du Sénégal relatives aux baux. L’attention du ou des preneurs, a été particulièrement attirée sur la teneur des articles ci-dessous cités : </p>
                 <p> ARTICLE 1 :
                  Le preneur est tenu à trois (03) obligations principales : <br>
                  1) D’user sur la chose louée en bon père de famille et suivant la destination qui lui a été donnée par le bail ou suivant <br>
                  celle présumée d’après les circonstances à défaut de convention.<br>
                  2) De payer le terme du bail aux termes convenus.<br>
                  3) De veiller à ne pas troubler la jouissance paisible des voisins par le bruit, les odeurs, la fumée ou autrement de son fait <br>
                   ou du fait de ses ayants-droits ou de ses préposés</p>
                 <p> ARTICLE 2 :
                  S’il n’a pas été fait d’état des lieux, le preneur est présumé les avoir reçu en bon état de réparations locatives et doit les rendre <br>
                   tels qu’il les a trouvés au moment de la prise des clés, sauf la preuve du contraire.</p>
                 <p> ARTICLE 3 :
                  Il répond à l’incendie à moins qu’il ne prouve que l’incendie est arrivé par cas fortuit ou force majeure ou par vice <br>
                   de construction ou que le feu a été communiqué par une maison voisine. </p>
                 <p> ARTICLE 4 :
                  Il répond des dégradations ou pertes qui arrivent pendant sa jouissance à moins qu’il prouve qu’elles ont eu lieu sans sa faute. <br>
                  En conséquence des articles ci-dessus, le preneur accepte toutes détériorations quelles qu’elles soient et notamment carreaux <br>
                  cassés, clefs perdues, murs tachés, grillages moustiquaires cassées ou déchirées, etc., soient à sa charge. Un état des lieux <br>
                   sera dressé avant son départ. Il devra verser une provision suffisante pour couvrir les réparations qui seront jugés nécessaires et qui lui seront imputables. <br>
                  Il est rappelé que les frais de débouchage de toutes les canalisations notamment celle du « tout à l’égout » sont toujours à la charge du locataire.<br>
                  Pour garantir le recours du preneur contre le propriétaire en cas d’incendie, de vol ou de dégâts des eaux,<br> le preneur s’engage à assurer ses risques locatifs ainsi que les objets garnissant les lieux loués à une Compagnie d’Assurances Notoirement solvable au moment de son entrée en jouissance.
                  Le preneur s’interdit de sous-louer ou de céder son droit au présent contrat sans en référer au propriétaire ou son représentant suivant <br>
                  les dispositions de la loi n°66-70 du 13 juillet 1966. </p>
                 <p> ARTICLE 5 :
                  Chacune des deux parties a la faculté de dénoncer le présent engagement, à tout moment par lettre recommandée 06 (six) mois <br>
                  à l’avance pour le bailleur ou par exploit d’huissier et 02 (deux) mois pour le preneur. <br>
                  Lorsque le preneur aura reçu ou donné congé, le bailleur pourra faire mettre un écriteau à l’emplacement de son choix <br> 
                  indiquant que les lieux sont à louer. Le preneur devra laisser visiter les jours ouvrables sur rendez-vous au moins 3 fois par <br>
                   semaine. Il en serait de même en cas de mise en vente des locaux.<br>
                  <strong> CLAUSE RESOLUTOIRE </strong>
                  A défaut de paiement à son échéance d’un seul terme de loyer ou d’inexécution de l’une des conditions qui précédent,<br>
                   le présent contrat sera résilié de plein droit trente jours après un simple commandement de payer ou de mise en demeure <br>
                    d’exécuter resté sans effet sans qu’il soit besoin de remplir d’autres formalités judiciaires. Une simple ordonnance de référé <br>
                     autorisant l’expulsion et nonobstant toutes offres ou consignes ultérieures et attributions est donnée au Président du tribunal <br>
                      statuant en référé pour ordonner dans ce cas l’expulsion du locataire.<br>
                  En cas de procédure, les frais de celle-ci et les honoraires de l’avocat sont à la charge du locataire.</p>
                  <p> <strong> FAIT à DAKAR, </strong>
                  <strong>Le ……/…../………. </strong>
                  En Trois (03) exemplaires
                 <strong> LE PRENEUR LE BAILLEUR </strong> </p>

                 <h3> <strong> Liste Nominative des Réparations et Entretiens Courant aux Charges des Locataires </strong> </h3>
                  <p>   - Tous les travaux ayant pour objet de rendre plus agréable l’occupation du logement, pose des consoles et étagères, confection de placards et panneaux, etc.……. <br>
                  - L’entretien des cuisinières, fourneaux et des tuyaux ou colonnes à fumée (ramonage).<br>
                  - Dégorgement des baignoires, lavabos, éviers, WC, douches, tout appareils sanitaires et tuyaux de descente particuliers y compris ceux de balcon.<br>
                  - L’entretien des appareils d’éclairage et de distribution d’eau et d’électricité, le remplacement des robinets commutateurs et prise de courant.<br>
                  - L’entretien et le remplacement des tablettes, porte-éponge, porte-savon et porte-serviette, triangle à rideaux de douche.<br>
                  - L’entretien des fermetures, des barrières serrures, bec de canne, targettes, verrous et crémones.<br>
                  - Le remplacement des crochets d’arrêt, des portes, fenêtres et autres ouvertures perdues ou faussées.<br>
                  - L’entretien des taquets, loqueteaux, arrêts et fléaux des croisés.<br>
                  - La réparation des dégâts causés en plantant des clous, pilons et autres dispositifs d’accrochage tant dans les murs que les boiseries, parquets ou plafonds.<br>
                  - Le remplacement des vitres.<br>
                  - La réparation des trous faits par l’occupant dans les mûrs, planchers et cloisons du fait de la pose et de l’enlèvement d’objets scellés appartenant à l’occupant.<br></p>
                <strong>  LE LOCATAIRE 
                  ………………………………………. </strong>
                <p>  Lu et approuvé </p>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

     
              <!-- /.row -->
              <!-- this row will not appear when printing -->
              
              <!-- this row will not appear when printing -->
              <div class="row no-print" >
                <div class="col-12">
                   <button  @click="annuler()" type="button" class="btn btn-danger float-left">
                    <i class="fas fa-trash"></i>
                    annuler
                  </button>
                  <button @click="printDetails()" type="button" class="btn btn-success float-right">
                    <i class="fas fa-print"></i>
                    contrat
                  </button>
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
</template>

<script>
import notFoundComponentVue from "./notFoundComponent.vue";

export default {
  mounted() {
    console.log("Component mounted.");
    this.getResults();
    this.clientD;
    setTimeout(function() {
      $("#table").DataTable({
        language: {
          url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
        }
      });
    }, 2000);
  },
  components: {
    "not-found": notFoundComponentVue
  },
  data() {
    return {
      Biens: {},
      client: {},
      operation: {},
      bien: {},
      clientD: {},
      date: new Date(),
      showTab: true,
      contratL: false,
      detailOperation: false,
      showForm: false,
      showForm2: "",
      piece: "",
      derniereleve: "",
      form: new Form({
        bien_id: "",
        details: "",
        etat: "",
        libelle: "",
        prix: "",
        adresse: "",
        caution: "",
        montantPaye: "",
        dateEntre: "",
        client: "",
        libelleE: "",
        numero: "",
        commission: "",
        taxes: "",
        durée: "",
        dernierelevé: "",
        piece: "",
        commentaire: ""
      }),
      formT: new Form({
        numero: ""
      })
    };
  },
  methods: {
    // Our method to GET results from a Laravel endpoint
    getResults(page = 1) {
      axios.get("api/listebiens?page=" + page).then(response => {
        this.Biens = response.data;
      });
    },
    printDetails() {
      window.print();
      this.contratL = false;
      this.showTab = true;
    },
    print() {
      this.contratL = true;
    },
    detail(bien) {
      this.showTab = false;
      this.showForm = true;
      this.form.fill(bien);
    },
    finaliser() {
      this.$Progress.start();
      // Submit the form via a POST request
      if (this.form.libelleE == "indisponible") {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "message"
        });
      }
      var fichier = new FormData();
      fichier.append("bien_id", this.form.bien_id);
      fichier.append("details", this.form.details);
      fichier.append("etat", this.form.etat);
      fichier.append("libelle", this.form.libelle);
      fichier.append("prix", this.form.prix);
      fichier.append("adresse", this.form.adresse);
      fichier.append("caution", this.form.caution);
      fichier.append("montantPaye", this.form.montantPaye);
      fichier.append("dateEntre", this.form.dateEntre);
      fichier.append("client", this.form.client);
      fichier.append("libelleE", this.form.libelleE);
      fichier.append("numero", this.form.numero);
      fichier.append("commission", this.form.commission);
      fichier.append("taxes", this.form.taxes);
      fichier.append("durée", this.form.durée);
      fichier.append("dernierelevé", this.derniereleve);
      fichier.append("piece", this.piece);
      fichier.append("commentaire", this.form.commentaire);

      axios
        .post("/api/louer", fichier)
        .then(response => {
          //this will update dom automatically
          //this.loadUsers();
          let message = response.data.message;
          let status = response.data.status;
          console.log(message);
          if (status == 500) {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: message
            });
            this.$Progress.finish();
          } else {
            this.operation = response.data.Operation;
            this.client = response.data.client;
            this.bien = response.data.bien;
            this.getResults();
            Toast.fire({
              icon: "success",
              title: "User created successfully"
            });
            this.$Progress.finish();
            this.detailOperation = false;
            this.showForm = false;
            this.showTab = false;
            this.contratL = true;
          }
        })
        .catch(e => {
          console.log(e);
        });
    },
    findClient() {
      this.formT.post("/api/findclient").then(response => {
        let client = response.data;
        this.form.client = client.nom;
        this.form.numero = client.tel;
        this.clientD.nom = client.nom;
        this.clientD.prenom = client.prenom;
        if (this.clientD.prenom) {
          this.showForm2 = true;
        }
      });
    },
    annuler() {
      location.reload();
    },
    contrat() {
      this.showTab = true;
    },

    updateDernier(e) {
      console.log(e);
      this.derniereleve = e.target.files[0];

      this.ext_image2 = [
        "image/jpeg",
        "application/pdf",
        "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
        "image/png",
        "application/vnd.oasis.opendocument.text"
      ];

      if (this.ext_image2.indexOf(this.derniereleve.type) < 0) {
        Swal.fire({
          type: "error",
          title: "Oops...",
          text:
            "Vous devez choisir soit fichier pdf, soit un fichier word, soit une image "
        });
        document.getElementById("derniereleve").value = "";
        return;
      }
    },
    updatePiece(e) {
      console.log(e);
      this.piece = e.target.files[0];

      this.ext_image2 = [
        "image/jpeg",
        "application/pdf",
        "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
        "image/png",
        "application/vnd.oasis.opendocument.text"
      ];

      if (this.ext_image2.indexOf(this.piece.type) < 0) {
        Swal.fire({
          type: "error",
          title: "Oops...",
          text:
            "Vous devez choisir soit fichier pdf, soit un fichier word, soit une image "
        });
        document.getElementById("piece").value = "";
        return;
      }
    },
    created() {
      Fire.$on("AfterCreate", () => {
        this.getResults();
      });
      //setInterval(()=>this.loadbiens(),10000)
    }
  }
};
</script>
