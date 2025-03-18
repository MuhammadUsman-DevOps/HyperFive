<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Services\SubscriberService;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    protected $subscriberService;

    public function __construct(SubscriberService $subscriberService)
    {
        $this->subscriberService = $subscriberService;
    }

    public function getAllSubscribers(Request $request)
    {
        $subscribers = $this->subscriberService->getSubscribers();

        if (!$subscribers) {
            return redirect()->route('login')->with('error', 'Please log in to access subscribers.');
        }

        return view('core.subscribers.subscribers', compact('subscribers'));
    }
    public function getSubscriber($ueId, $plmnId)
    {
        $subscriber = $this->subscriberService->getSubscriber($ueId, $plmnId);

        if (!$subscriber) {
            return redirect()->route('subscribers')->with('error', 'Subscriber not found.');
        }

        return view('core.subscribers.subscriber_detail', ['subscriber' => $subscriber]);
    }



    public function addSubscriber(Request $request, $ueId, $plmnId)
    {
        $request->validate([
            'plmnID' => 'required|string',
            'ueId' => 'required|string',
            'AuthenticationSubscription' => 'required|array',
            'AccessAndMobilitySubscriptionData' => 'required|array',
            'SessionManagementSubscriptionData' => 'required|array',
            'SmfSelectionSubscriptionData' => 'required|array',
            'AmPolicyData' => 'required|array',
            'SmPolicyData' => 'required|array',
            'FlowRules' => 'required|array',
            'QosFlows' => 'required|array',
        ]);

        $data = $request->all();

        $subscriber = $this->subscriberService->addSubscriber($ueId, $plmnId, $data);

        if (!$subscriber) {
            return redirect()->route('subscribers')->with('error', 'Failed to add subscriber.');
        }

        return redirect()->route('subscribers')->with('success', 'Subscriber added successfully.');
    }

    public function updateSubscriber(Request $request, $ueId, $plmnId)
    {
        $request->validate([
            'plmnID' => 'required|string',
            'ueId' => 'required|string',
            'AuthenticationSubscription' => 'required|array',
            'AccessAndMobilitySubscriptionData' => 'required|array',
            'SessionManagementSubscriptionData' => 'required|array',
            'SmfSelectionSubscriptionData' => 'required|array',
            'AmPolicyData' => 'required|array',
            'SmPolicyData' => 'required|array',
            'FlowRules' => 'required|array',
            'QosFlows' => 'required|array',
        ]);

        $data = $request->all();

        $subscriber = $this->subscriberService->updateSubscriber($ueId, $plmnId, $data);

        if (!$subscriber) {
            return redirect()->route('subscribers')->with('error', 'Failed to update subscriber.');
        }

        return redirect()->route('subscribers')->with('success', 'Subscriber updated successfully.');
    }

    public function deleteSubscriber($ueId, $plmnId)
    {
        $deleted = $this->subscriberService->deleteSubscriber($ueId, $plmnId);

        if (!$deleted) {
            return redirect()->route('subscribers')->with('error', 'Failed to delete subscriber.');
        }

        return redirect()->route('subscribers')->with('success', 'Subscriber deleted successfully.');
    }
}
