# UE4AM
persistent crossplatform online data interface for UE4
totally free even for commercial projects, released under MIT License

>> The project is currently in work and not finished yet! <<

If you like, work with me on this thing to make it a good free mmo solution for UE4
Please read the docs in the docs subdirectory

Tipps for creating a mmo game in UE4

- learn how you build a dedicated server in ue4
  so read this: https://wiki.unrealengine.com/Standalone_Dedicated_Server
  and     this: https://wiki.unrealengine.com/Dedicated_Server_Guide_(Windows_%26_Linux)

- get familiar with php and take a deep look on UE4AM framework in php (this thing)
  you need the php script to handle communication between the clients and the account. so you feed your client / player state with all needed account player info you received by your php script

- to make life easier in UE4, download VARest from ufna which gives you the possibility to handle json in blueprint
https://github.com/ufna/VaRest

- write a blueprint actor class where you handle all functions needed, like registeraccount, login, etc. these functions communicate with your php script you wrote before

