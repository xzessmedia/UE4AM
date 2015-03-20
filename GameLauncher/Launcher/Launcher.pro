#-------------------------------------------------
#
# Project created by QtCreator 2015-03-14T07:36:33
#
#-------------------------------------------------

QT       += core gui network

greaterThan(QT_MAJOR_VERSION, 4): QT += widgets

TARGET = Launcher
TEMPLATE = app


SOURCES += main.cpp\
        mainwindow.cpp \
    gameupdater.cpp \
    settings.cpp \
    updatewindow.cpp \
    jsonhandler.cpp

HEADERS  += mainwindow.h \
    gameupdater.h \
    settings.h \
    updatewindow.h \
    jsonhandler.h

FORMS    += mainwindow.ui
