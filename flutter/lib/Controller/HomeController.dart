import 'package:proxima_study/services/service.dart';
import 'package:get/get.dart';

class HomeController extends GetxController{

  final serviceController = Get.find<Service>();

  var isLoading = false.obs;
  var isLoadingOverlay = false.obs;
  var currentNavIndex = 0.obs;
  var closedApp = 0.obs;

  @override
  void onInit() async{
    super.onInit();
  }
  void onDispose(){
    super.dispose();
  }
}
