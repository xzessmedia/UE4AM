# UE4AM
persistent crossplatform online data interface for UE4
totally free even for commercial projects, released under MIT License
this project is actually WIP

Here is the UE4 Thread in the boards to connect in both directions:
https://forums.unrealengine.com/showthread.php?62642-UE4AM-free-persistent-online-data-storage-for-MMO-Games


[UE4AM Documentation]: http://www.seven-mountains.eu/docs/UE4AM/

Install Notes:

1. Upload all files to a webspace of your choice with PHP and MySQL installed
2. Edit /inc/settings.php with Notepad and setup your database there
3. Edit /inc/ue4am.sql with Notepad and setup your characters table (add all fields your game clients will need)
4. Call the script by navigating to the webspace and calling ue4am.php to install all SQL Tables

Additional Steps:

1. Download VARest by UFNA (https://github.com/ufna/VaRest) and put the plugin into your UE4 Projects /plugins/ subdirectory
2. Add some custom Events inside your UGameInstance for Registering, Syncing, Logging in, etc in Blueprint in direct communication with UE4AM, see docs for learning how it works. Sync your PlayerState with UE4AM onConnect i.e.
3. Build a dedicated Server with Unreal Build Tool
https://wiki.unrealengine.com/Standalone_Dedicated_Server
https://wiki.unrealengine.com/Dedicated_Server_Guide_(Windows_%26_Linux)

If you like, work with me on this thing to make it a good free mmo solution for UE4
Please read the docs in the docs subdirectory (just open /docs/html/index.html in your favourite browser)

Licensing Info:
This code is released as free Open Source under MIT License
You can use it in nonCommercial and Commercial Projects


I would be very happy if you work with UE4AM, fork it and start enhancing and sharing your great stuff with the Community like i am going to do!
Really appreciated: Blueprint Part in UE4 as a commit for UE4AM to make it a round package:
Free DropIn MMO or persistent database storage and account handling package

Free Open Source, Free Knowledge, Free Internet for a Free World











General Tipps for creating a mmo game in UE4

- learn how you build a dedicated server in ue4
  so read this: https://wiki.unrealengine.com/Standalone_Dedicated_Server
  and     this: https://wiki.unrealengine.com/Dedicated_Server_Guide_(Windows_%26_Linux)

- get familiar with php and take a deep look on UE4AM framework in php (this thing)
  you need the php script to handle communication between the clients and the account. so you feed your client / player state with all needed account player info you received by your php script

- to make life easier in UE4, download VARest from ufna which gives you the possibility to handle json in blueprint
https://github.com/ufna/VaRest

- write a blueprint actor class where you handle all functions needed, like registeraccount, login, etc. these functions communicate with your php script you wrote before

