#ifndef UPDATEWINDOW_H
#define UPDATEWINDOW_H

#include <QObject>
#include <QWidget>

class UpdateWindow : public QWidget
{
    Q_OBJECT
public:
    explicit UpdateWindow(QWidget *parent = 0);
    ~UpdateWindow();

signals:

public slots:
};

#endif // UPDATEWINDOW_H
