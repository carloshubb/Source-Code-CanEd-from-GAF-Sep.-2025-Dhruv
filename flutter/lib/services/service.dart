import 'dart:convert';

import 'package:proxima_study/consts/constFileLink.dart';
import 'package:flutter/material.dart';
import 'package:fluttertoast/fluttertoast.dart';

class Service extends GetxService{

  var token = "".obs;
  var loginUserId = "".obs;

 @override
  void onInit() async{
    // TODO: implement onInit
    super.onInit();
    //await getUserToken();
  }

  @override
  void onClose() {
  }


// getUserToken() async{
//   token.value = await secureStorage.read(key: "token") ?? "";
//   loginUserId.value = await secureStorage.read(key: "loginUserId") ?? "";
// }

  // logoutUser() async{
  //   secureStorage.deleteAll();
  //   Get.offAllNamed("/login_page");
  // }

  showSnackBar(String title, String message, Color backgroundColor){
    Get.snackbar(
        title,
        message,
        snackPosition: SnackPosition.BOTTOM,
        backgroundColor: backgroundColor,
        colorText: Colors.white
    );
  }

  showToast(message, position){
    Fluttertoast.showToast(
        msg: message,
        toastLength: Toast.LENGTH_SHORT,
        gravity: position,
        timeInSecForIosWeb: 1,
        backgroundColor: Colors.black.withOpacity(0.7),
        textColor: Colors.white,
        fontSize: 12.0
    );
  }

Future<bool> showConfirmationDialog(message) async {
  return await Get.defaultDialog(
    title: 'Confirm',
    middleText: message,
    actions: [
      ElevatedButton(
        onPressed: () => Get.back(result: false),
        child: Text('No'),
        style: ElevatedButton.styleFrom(
          backgroundColor: secondaryColor,
          foregroundColor: Colors.white
        ),
      ),
      ElevatedButton(
        onPressed: () => Get.back(result: true),
        child: Text('Yes'),
        style: ElevatedButton.styleFrom(
          backgroundColor: primaryColor,
          foregroundColor: Colors.white
        ),
      ),
    ],
  );
}
}