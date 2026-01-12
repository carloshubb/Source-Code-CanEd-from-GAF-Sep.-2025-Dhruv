import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:proxima_study/Controller/BindingController.dart';
import 'package:proxima_study/pages/navigation_page.dart';
import 'package:proxima_study/pages/splash_page.dart';
import 'package:proxima_study/services/service.dart';

import 'consts/constFileLink.dart';

void main() async{
  WidgetsFlutterBinding.ensureInitialized();
  SystemChrome.setPreferredOrientations([
    DeviceOrientation.portraitUp,
    DeviceOrientation.portraitDown
  ]);
  await initService();
  runApp(const MyApp());
}

Future<void> initService() async{
  await Get.putAsync<Service>(() async => Service());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  // This widget is the root of your application.
  @override
  Widget build(BuildContext context) {
    return GetMaterialApp(
      debugShowCheckedModeBanner: false,
      initialBinding: BindingController(),
      title: appName,
      theme: ThemeData(
          scaffoldBackgroundColor: Colors.white,
          appBarTheme: const AppBarTheme(backgroundColor: Colors.white),
          fontFamily: regular
      ),
      initialRoute: '/',
      defaultTransition: Transition.zoom,
      getPages: [
        GetPage(name: '/', page: () => SplashPage()),
        //GetPage(name: '/navigation_page', page: () => NavigationPage()),
      ],
    );
  }
}

