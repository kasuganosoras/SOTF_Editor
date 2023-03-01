<?php
if(isset($_GET['type']) && is_string($_GET['type'])) {
    switch($_GET['type']) {
        case "inventory":
            if(isset($_POST['data']) && is_string($_POST['data'])) {
                $data = json_decode($_POST['data'], true);
                foreach($data['ItemInstanceManagerData']['ItemBlocks'] as $di => $item) {
                    if(isset($item['UniqueItems']) && is_array($item['UniqueItems'])) {
                        foreach($item['UniqueItems'] as $ui => $uniqueItem) {
                            if(isset($uniqueItem['Modules']) && is_array($uniqueItem['Modules'])) {
                                foreach($uniqueItem['Modules'] as $mi => $module) {
                                    if(isset($module['ChannelWeights']) && is_array($module['ChannelWeights'])) {
                                        $module['ChannelWeights']['x'] = floatval($module['ChannelWeights']['x']);
                                        $module['ChannelWeights']['y'] = floatval($module['ChannelWeights']['y']);
                                        $module['ChannelWeights']['z'] = floatval($module['ChannelWeights']['z']);
                                        $module['ChannelWeights']['w'] = floatval($module['ChannelWeights']['w']);
                                        $uniqueItem['Modules'][$mi] = $module;
                                    }
                                }
                                $data['ItemInstanceManagerData']['ItemBlocks'][$di]['UniqueItems'][$ui] = $uniqueItem;
                            }
                        }
                    }
                }
                if(isset($data['QuickSelect'])) {
                    foreach($data['QuickSelect']['Slots'] as $si => $slot) {
                        if(isset($slot['Age'])) {
                            $data['QuickSelect']['Slots'][$si]['Age'] = floatval($slot['Age']);
                        }
                    }
                }
                Header('Content-Type: application/json');
                $json = json_encode($data, JSON_PRESERVE_ZERO_FRACTION);
                // replace x.xxxxxxe-xx with x.xxxxxxE-xx
                $json = preg_replace('/([0-9]+)\.([0-9]+)e-([0-9]+)/i', '$1.$2E-$3', $json);
                echo $json;
            }
            break;
        case "entities":
            if(isset($_POST['data']) && is_string($_POST['data'])) {
                $data = json_decode($_POST['data'], true);
                if($data && isset($data['Actors'])) {
                    foreach($data['Actors'] as $i => $actors) {
                        if(isset($actors['Position'])) {
                            $data['Actors'][$i]['Position']['x'] = floatval($actors['Position']['x']);
                            $data['Actors'][$i]['Position']['y'] = floatval($actors['Position']['y']);
                            $data['Actors'][$i]['Position']['z'] = floatval($actors['Position']['z']);
                        }
                        if(isset($actors['Rotation'])) {
                            $data['Actors'][$i]['Rotation']['x'] = floatval($actors['Rotation']['x']);
                            $data['Actors'][$i]['Rotation']['y'] = floatval($actors['Rotation']['y']);
                            $data['Actors'][$i]['Rotation']['z'] = floatval($actors['Rotation']['z']);
                            $data['Actors'][$i]['Rotation']['w'] = floatval($actors['Rotation']['w']);
                        }
                        if(isset($actors['Stats'])) {
                            $data['Actors'][$i]['Stats']['Health'] = floatval($actors['Stats']['Health']);
                            $data['Actors'][$i]['Stats']['Anger'] = floatval($actors['Stats']['Anger']);
                            $data['Actors'][$i]['Stats']['Fear'] = floatval($actors['Stats']['Fear']);
                            $data['Actors'][$i]['Stats']['Fullness'] = floatval($actors['Stats']['Fullness']);
                            $data['Actors'][$i]['Stats']['Hydration'] = floatval($actors['Stats']['Hydration']);
                            $data['Actors'][$i]['Stats']['Energy'] = floatval($actors['Stats']['Energy']);
                            $data['Actors'][$i]['Stats']['Affection'] = floatval($actors['Stats']['Affection']);
                        }
                        $data['Actors'][$i]['NextGiftTime'] = $data['Actors'][$i]['NextGiftTime'] ? floatval($actors['NextGiftTime']) : $data['Actors'][$i]['NextGiftTime'];
                        $data['Actors'][$i]['LastVisitTime'] = $data['Actors'][$i]['LastVisitTime'] ? floatval($actors['LastVisitTime']) : $data['Actors'][$i]['LastVisitTime'];
                    }
                }
                Header('Content-Type: application/json');
                $json = json_encode($data, JSON_PRESERVE_ZERO_FRACTION);
                echo $json;
            } else {
                echo "Invalid data";
            }
            break;
        default:
            echo "Invalid type";
            break;
    }
}
